<?php

require_once("Db.php");
require_once("Utill.php");
require_once("dao/TaskDao.php");

$typePost = filter_input(INPUT_POST, "typePost");

$typeGet = filter_input(INPUT_GET, "typeGet");

if ($typeGet) {
    switch ($typeGet) {
    case "getAllTask":

        $dao = new TaskDao(Db::getConnection());

        $tasks = $dao->getAll();

        Utill::respMessage(200, ['data' => $tasks]);
    break;
    }
}

if ($typePost) {
    switch ($typePost) {
    case "createTask":
        $title = filter_input(INPUT_POST, "input-task");
        $reward = filter_input(INPUT_POST, "input-reward");
        $priority = filter_input(INPUT_POST, "select-priority");
        $points = filter_input(INPUT_POST, "input-points");

        if ($title && $reward && $priority && $points) {

            $dao = new TaskDao(Db::getConnection());

            if ($dao->create($title, $reward, $priority, (int) $points, new DateTime())) {
                Utill::respMessage(200, ['message' => 'Salvo com sucesso!', 'type' => "info", 'success' => true]);
            } else {
                Utill::respMessage(400, ['message' => 'Erro ao salvar.', 'type' => "danger", 'success' => false]);
            }
        } else {

        }
    break;
    case "optionTask":

        $id = filter_input(INPUT_POST, "id");
        $option = filter_input(INPUT_POST, "action");

        if ($option == "completed") {
           
        } else if ($option == "remove") {

        } else {
            
        }

    break;
    default:
        Utill::respMessage(400, ['message' => 'Ação inválida', 'type' => "danger", 'success' => false]);
    break;
    }
}

