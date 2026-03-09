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

      <div>
        <div class="vTrack" aria-label="Barra vertical de progresso">
          <div class="vFill" id="vFill"></div>
        </div>
        <div class="vLabel"><span id="percent">0</span>% concluído</div>
      </div>

      <div class="card">
        <div class="small">Configurações</div>
        <div class="row" style="margin-top:8px;">
          <label class="w200">
            Meta de pontos
            <input id="goalInput" type="number" min="1" step="1" value="10">
          </label>
          <label class="grow">
            Recompensa (texto)
            <input id="rewardInput" type="text" placeholder="Ex.: 1 hora de jogo / 1 sobremesa / 1 episódio">
          </label>
        </div>
        <div class="row" style="margin-top:8px;">
          <button class="btnPrimary" id="saveSettings">Salvar configurações</button>
          <button id="resetPoints">Zerar pontos</button>
        </div>
      </div>

      <div class="rewardBox">
        <div class="msg" id="rewardMsg">Defina uma recompensa e conclua tarefas para desbloquear.</div>
        <div class="actions">
          <button id="claimReward" class="btnPrimary" disabled>Resgatar recompensa</button>
          <button class="default-btn btn-danger">Resetar tudo</button>
        </div>
      </div>
    </section>

    <section class="all-section" id="section-task">
      <div id="alert-message" class="alert py-2"></div>
      <form id="form-task">
        <input type="hidden" name="type" value="add-Task">
        <div class="form-grup">
          <label for="input-task">Nova tarefa</label>
          <input type="text" name="input-task" id="input-task">
        </div>
        <div class="form-grup">
          <select name="select-priority" id="select-priority">
            <option value="" disabled selected>Selecione</option>
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
            <th>#</th>
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
