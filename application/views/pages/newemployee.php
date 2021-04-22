<div class="newemployee">
    <div class="adj-top"></div> <!-- adj-top -->
    <section class="right new-emp w82">

        <?php
        // Input values
        $nome = $cpf = $departamento = $rua = $bairro = $numero = $cidade = $estado = "";
        if (isset($_GET['id'])) {
            $nome = $_GET['nome'];
            $cpf = $_GET['cpf'];
            $departamento = $_GET['departamento'];
            $rua = $_GET['rua'];
            $bairro = $_GET['bairro'];
            $numero = $_GET['numero'];
            $cidade = $_GET['cidade'];
            $estado = $_GET['estado'];
        }
        ?>

        <div class="center">
            <div class="form-block">
                <h3><?php echo $formTitle; ?></h3>
                <form id="form-register-emp" action="" method="post">
                    <div class="center">
                        <div class="form-single">
                            <label for="name">Nome</label><br>
                            <input id="name" type="text" name="name" value="<?php echo $nome; ?>" />
                        </div> <!-- form-single -->
                        <div class="form-single">
                            <label for="cpf">CPF</label><br>
                            <input id="cpf" type="text" name="cpf" value="<?php echo $cpf; ?>" />
                        </div> <!-- form-single -->
                        <div class="form-single">
                            <label for="department">Departamento</label><br>
                            <input id="department" type="text" name="department" value="<?php echo $departamento; ?>" />
                        </div> <!-- form-single -->
                        <br>
                        <p>Endereço</p><br>
                        <div class="form-single">
                            <label for="street">Rua</label>
                            <input id="street" type="text" name="street" value="<?php echo $rua; ?>" />
                        </div> <!-- form-single -->
                        <div class="form-single w75 left">
                            <label for="district">Bairro</label>
                            <input id="district" type="text" name="district" value="<?php echo $bairro; ?>" />
                        </div> <!-- form-single -->
                        <div class="form-single w25 left">
                            <label for="number">Número</label>
                            <input id="number" type="text" name="number" value="<?php echo $numero; ?>" />
                        </div> <!-- form-single -->

                        <div class="form-single w75 left">
                            <label for="city">Cidade</label>
                            <input id="city" type="text" name="city" value="<?php echo $cidade; ?>" />
                        </div> <!-- form-single -->
                        <div class="form-single w25 left">
                            <label for="state">Estado</label><br>
                            <select name="state" id="state">
                                <?php
                                foreach ($ufs as $uf) {
                                    if ($uf == $estado) {
                                        echo '<option value="' . $uf . '" selected>' . $uf . '</option>';
                                        continue;
                                    }
                                    echo '<option value="' . $uf . '">' . $uf . '</option>';
                                }
                                ?>
                            </select>
                        </div> <!-- form-single -->
                        <div class="clear"></div><br>

                        <button id="register-emp" type="button" class="submit-bttn">Salvar</button>
                        
                    </div> <!-- centert:modf -->
                </form>
                <div class="errorMsg"><?php echo validation_errors(); ?></div>
            </div> <!-- form-block -->
        </div> <!-- center -->

    </section>
    <div class="clear"></div>

</div> <!-- newemployee -->