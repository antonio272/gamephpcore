<?php
    require("config.php");

    /* apagar só a autenticação do utilizador da sessão */
    unset($_SESSION["user_id"]);

    /* em alternativa, destruir tudo o que está na sessão, inclusive o carrinho */
    session_destroy();

    header("Location: index.php");
