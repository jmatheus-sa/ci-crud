<div class="newdependent">
    <div class="adj-top"></div> <!-- adj-top -->
    <section class="right new-dep w82">

        <?php
        // Input values
        $id_func = $nome_func = $cpf_func = $departamento = "";
        $nome = $cpf = $idade = "";
        if (isset($_GET['id_func'])) {
            $id_func = $_GET['id_func'];
            $nome_func = $_GET['nome_func'];
            $cpf_func = $_GET['cpf_func'];
            $departamento = $_GET['departamento'];
        }
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $nome = $_GET['nome'];
            $idade = $_GET['idade'];
            $cpf = $_GET['cpf'];
        }
        ?>

        <div class="center">
            <div class="form-block">
                <h3><?php echo $formTitle; ?></h3>

                <form id="form-register-dep" action="" method="post">
                    <div class="center">
                        <p>Funcionário</p>
                        <div class="func-data-wrapper">
                            <p><b>ID:</b> <?php echo $id_func; ?></p>
                            <p><b>CPF:</b> <?php echo $cpf_func; ?></p>
                            <p><b>Nome:</b> <?php echo $nome_func; ?></p>
                            <p><b>Departamento:</b> <?php echo $departamento; ?></p>
                        </div>
                        <div class="form-single">
                            <label for="name">Nome do Dependente</label><br>
                            <input id="name" type="text" name="name" value="<?php echo $nome; ?>" />
                        </div> <!-- form-single -->
                        <div class="form-single w75 left">
                            <label for="cpf">CPF do Dependente</label><br>
                            <input id="cpf" type="text" name="cpf" value="<?php echo $cpf; ?>" />
                        </div><!-- form-single -->
                        <div class="form-single w25 left">
                            <label for="age">Idade do Dependente</label><br>
                            <input id="age" type="text" name="age" value="<?php echo $idade; ?>" />
                        </div><!-- form-single -->
                        <div class="clear"></div><br>

                        <button type="button" class="submit-bttn" id="register-dep">Salvar</button>
                    </div> <!-- centert:modf -->
                </form>
                <div class="errorMsg"><?php echo validation_errors(); ?></div>
            </div> <!-- form-block -->
        </div> <!-- center -->

    </section>
    <div class="clear"></div>

</div> <!-- newemployee -->