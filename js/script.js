const tasksBody = document.getElementById("tasks-body");

document.addEventListener("DOMContentLoaded", function () {

  if (tasksBody) {
    loadTasks();
  }

  document.addEventListener('submit', function(event) {
    const form = event.target.closest('form');

    if (form && form.classList.contains('js-form')) {
      sendForm(event, form);
    }
  });

});

// Estado agora vem do back-end em JSON
let state = {
  points: 0,
  goal: 10,
  rewardText: "",
  rewardClaimedAt: null,
  tasks: []
};

const els = {
  points: document.getElementById("points"),
  goal: document.getElementById("goal"),
  percent: document.getElementById("percent"),
  vFill: document.getElementById("vFill"),
  goalInput: document.getElementById("goalInput"),
  rewardInput: document.getElementById("rewardInput"),
  saveSettings: document.getElementById("saveSettings"),
  resetPoints: document.getElementById("resetPoints"),
  resetAll: document.getElementById("resetAll"),
  claimReward: document.getElementById("claimReward"),
  rewardMsg: document.getElementById("rewardMsg"),
  taskTitle: document.getElementById("taskTitle"),
  taskCategory: document.getElementById("taskCategory"),
  addTask: document.getElementById("addTask"),
  tasksBody: document.getElementById("tasksBody"),
  statsLine: document.getElementById("statsLine"),
};

// helpers de HTTP
async function apiGet(url) {
  const resp = await fetch(url, {
    headers: { "Accept": "application/json" }
  });
  if (!resp.ok) throw new Error(await resp.text());
  return resp.json();
}

async function apiSend(url, method, body) {
  const resp = await fetch(url, {
    method,
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json"
    },
    body: body ? JSON.stringify(body) : undefined
  });
  if (!resp.ok) throw new Error(await resp.text());
  return resp.json();
}

// ---- lógica de UI permanece quase igual ----

function computeProgressPercent() {
  const pct = Math.floor(Math.min(100, (state.points / state.goal) * 100));
  return Number.isFinite(pct) ? pct : 0;
}

function escapeHtml(str){
  return str.replace(/[&<>"']/g, (m) => ({
    "&":"&amp;", "<":"&lt;", ">":"&gt;", '"':"&quot;", "'":"&#039;"
  }[m]));
}

function updateRewardUI() {
  const unlocked = state.points >= state.goal;
  const reward = state.rewardText?.trim();

  if (!reward) {
    els.rewardMsg.innerHTML = `Defina uma recompensa e conclua tarefas para desbloquear.`;
    els.claimReward.disabled = true;
    return;
  }

  if (unlocked) {
    els.rewardMsg.innerHTML = `Recompensa desbloqueada: <strong>${escapeHtml(reward)}</strong>.`;
    els.claimReward.disabled = false;
  } else {
    const faltam = Math.max(0, state.goal - state.points);
    els.rewardMsg.innerHTML =
      `Recompensa: <strong>${escapeHtml(reward)}</strong>. ` +
      `Falta(m) <strong>${faltam}</strong> ponto(s).`;
    els.claimReward.disabled = true;
  }
}

function render() {
  els.points.textContent = String(state.points);
  els.goal.textContent = String(state.goal);

  const pct = computeProgressPercent();
  els.percent.textContent = String(pct);
  els.vFill.style.height = pct + "%";

  els.goalInput.value = String(state.goal);
  els.rewardInput.value = state.rewardText || "";

  const total = state.tasks.length;
  const done = state.tasks.filter(t => t.done).length;
  els.statsLine.textContent = `Tarefas: ${total} total, ${done} concluída(s).`;

  els.tasksBody.innerHTML = "";
  state.tasks.forEach((t, idx) => {
    const tr = document.createElement("tr");

    const tdIdx = document.createElement("td");
    tdIdx.textContent = String(idx + 1);

    const tdTitle = document.createElement("td");
    tdTitle.textContent = t.title;

    const tdCat = document.createElement("td");
    tdCat.textContent = t.category || "-";

    const tdStatus = document.createElement("td");
    const tag = document.createElement("span");
    tag.className = "tag " + (t.done ? "done" : "todo");
    tag.textContent = t.done ? "Concluída (+1)" : "Pendente";
    tdStatus.appendChild(tag);

    const tdActions = document.createElement("td");
    tdActions.className = "tdActions";

    const btnToggle = document.createElement("button");
    btnToggle.textContent = t.done ? "Desfazer" : "Concluir";
    btnToggle.addEventListener("click", () => toggleDone(t.id));

    const btnDel = document.createElement("button");
    btnDel.className = "btnDanger";
    btnDel.textContent = "Excluir";
    btnDel.addEventListener("click", () => deleteTask(t.id));

    tdActions.appendChild(btnToggle);
    tdActions.appendChild(btnDel);

    tr.appendChild(tdIdx);
    tr.appendChild(tdTitle);
    tr.appendChild(tdCat);
    tr.appendChild(tdStatus);
    tr.appendChild(tdActions);

    els.tasksBody.appendChild(tr);
  });

  updateRewardUI();
}

function sendForm(event, formEl) {
  event.preventDefault();

  const formData = new FormData(formEl);

  fetch(formEl.action, {
    method: formEl.method || 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    console.log(data);
    if (data.success) {
      loadTasks();
      showAlert(data.message, data.type);
    } else {
      showAlert(data.message, data.type);
    }
  })
  .catch((error) => {
    showAlert("Ocorreu um erro inesperado" + error, "danger");
  });
}

function showAlert(message, type) {
  const alertMessage = document.getElementById('alert-message');

  function updateAlert(alertElement, message, type) {
    alertElement.textContent = message;
    alertElement.classList.remove('alert-info', 'alert-danger');
    alertElement.classList.add(`alert-${type}`);
    alertElement.style.display = 'block';
  }

  updateAlert(alertMessage, message, type);
}

async function loadTasks() {
  const params = new URLSearchParams({
    typeGet: 'getAllTask'
  });

  fetch(`/Process.php?${params.toString()}`)
  .then(res => res.json())
  .then(response => {
    if (Array.isArray(response.data) && response.data.length > 0) {
      renderTask(response.data);
    }
  })
  .catch((error) => {
    showAlert("Ocorreu um erro inesperado", "danger");
  });
}

function renderTask(list) {
  if (!Array.isArray(list) || list.length === 0) {
    return;
  }

  list.forEach(element => {
    const html = `
      <tr>
        <td>${element.title}</td>
        <td>${element.priority}</td>
        <td>${element.points}</td>
        <td id="td-action">
          <form action="/Process.php" class="js-form" method="POST">
            <input type="hidden" name="typePost" value="optionTask">
            <input type="hidden" name="action" value="completed">
            <input type="hidden" name="id" value="${element.id}">
            <button class="default-btn btn-save" type="submit">Completo</button>
          </form>
          <form action="/Process.php" class="js-form" method="POST">
            <input type="hidden" name="typePost" value="optionTask">
            <input type="hidden" name="action" value="remove">
            <input type="hidden" name="id" value="${element.id}">
            <button class="default-btn btn-danger" type="submit">Remover</button>
          </form>
        </td>
      </tr>
    `;
    tasksBody.insertAdjacentHTML("beforeend", html);
  });
}