<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Lista de Tarefas</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main id="general">
    <!--barra de progreso-->
    <section class="all-section" id="section-progress">
      <div class="progress-top">
        <div class="points-status" id="total-points">Pontos: 0</div>
        <div class="points-status" id="points-target">Meta: 100</div>
      </div>

      <div id="progress-bar">
        <div id="bar-view">
          <div id="bar-load"></div>
        </div>
        <p id="bar-status"><span id="bar-percent">0</span>% concluído</p>
      </div>
    </section>

    <section class="all-section" id="section-task">
      <div id="alert-message" class="alert py-2"></div>
      <form action="/Process.php" id="form-task" class="js-form" method="POST">
        <input type="hidden" name="typePost" value="createTask">
        <div class="form-grup">
          <label for="input-task">Nova tarefa</label>
          <input type="text" name="input-task" id="input-task">
        </div>
        <div class="form-grup">
          <label for="input-reward">Recompensa</label>
          <input type="text" name="input-reward" id="input-reward">
        </div>
        <div class="form-grup">
          <select name="select-priority" id="select-priority">
            <option value="" disabled selected>Prioriadade</option>
            <option value="alta">Alta</option>
            <option value="media">Media</option>
            <option value="baixa">Baixa</option>
          </select>
        </div>
        <div class="form-grup">
          <label for="input-points">Pontos</label>
          <input type="text" name="input-points" id="input-points">
        </div>
        <button class="default-btn btn-save" type="submit">Salvar</button>
        <button class="default-btn btn-danger" type="reset">Limpar</button>
      </form>

      <hr class="space-line"></hr>

      <table id="table-task">
        <thead id="task-thead">
          <tr>
            <th>Tarefas</th>
            <th>Prioriadade</th>
            <th>Valor</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody id="tasks-body"></tbody>
      </table>
    </section>
  </main>
  <script src="js/script.js"></script>
</body>
</html>
