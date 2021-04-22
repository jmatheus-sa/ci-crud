<div class="employees">

    <div class="adj-top"></div>
    <section class="right emps w82">

        <div class="center">
            <div class="table-block">
                <table class="single-th">
                    <!-- Table Header -->
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Departamento</th>
                    </tr>
                </table>
                <?php
                for ($i = 0; $i < $nFunc; $i++) {
                    $emp = $funcionario;
                ?>

                    <table class="single-td single-td-slide">
                        <tr>
                            <td><?php echo $funcionario[$i]['id']; ?></td>
                            <td><?php echo $funcionario[$i]['nome']; ?></td>
                            <td><?php echo $funcionario[$i]['departamento']; ?></td>
                        </tr>
                    </table>
                    <div class="func-data">
                        <!-- [Employee Data: cpf, address, dependents -->
                        <p><b>CPF: </b><?php echo $funcionario[$i]['cpf'] ?></p>
                        <hr />
                        <h3>ENDEREÇO</h3>
                        <p class="address"><b>Rua: </b><?php echo $funcionario[$i]['rua']; ?></p>
                        <p class="address"><b>Bairro: </b><?php echo $funcionario[$i]['bairro']; ?></p>
                        <p class="address"><b>Número: </b><?php echo $funcionario[$i]['numero']; ?></p>
                        <p class="address"><b>Cidade: </b><?php echo $funcionario[$i]['cidade']; ?></p>
                        <p class="address"><b>UF: </b><?php echo $funcionario[$i]['estadouf']; ?></p>
                        <p class="address"><b>Estado: </b><?php echo $funcionario[$i]['estadonome']; ?></p>
                        <hr />
                        <h3>DEPENDENTES</h3>
                        <?php
                        if (!($dependente == null)) {
                            $dep = $dependente;
                            for ($ii = 0; $ii < $nDeps[$i]; $ii++) {
                        ?>
                                <p class="deps"><b>Nome: </b><?php echo $dependente[$i][$ii]['nome']; ?></p>
                                <p class="deps"><b>Idade: </b><?php echo $dependente[$i][$ii]['idade']; ?></p>
                                <p class="deps"><b>CPF: </b><?php echo $dependente[$i][$ii]['cpf']; ?></p>
                                <!-- Tag 'a' to edit a dependent -->
                                <a class="edit-emp" href="http://localhost/ci-crud/editar_dependente?id=<?php echo $dep[$i][$ii]['id']; ?>&nome=<?php echo $dep[$i][$ii]['nome']; ?>&idade=<?php echo $dep[$i][$ii]['idade']; ?>&cpf=<?php echo $dep[$i][$ii]['cpf']; ?>&id_func=<?php echo $emp[$i]['id']; ?>&nome_func=<?php echo $emp[$i]['nome']; ?>&cpf_func=<?php echo $emp[$i]['cpf']; ?>&departamento=<?php echo $emp[$i]['departamento']; ?>">
                                    <div>Editar</div>
                                </a>
                                <!-- Button to delete a dependent -->
                                <button data-emp-id="<?php echo $emp[$i]['id']; ?>" data-emp-name="<?php echo $emp[$i]['nome']; ?>" data-emp-depart="<?php echo $emp[$i]['departamento']; ?>" 
                                data-emp-cpf="<?php echo $emp[$i]['cpf']; ?>" data-dep-name="<?php echo $dep[$i][$ii]['nome']; ?>" data-del-url="<?php echo site_url("Lti/delDependent") . "/" . $dep[$i][$ii]['id'] . "/" . $emp[$i]['id']; ?>" type="button" class="del-emp conf-del-dep">Excluir</button>

                                <br><br>
                        <?php
                            }
                        }
                        ?>
                        <!-- Tag 'a' to register a dependent -->
                        <a class="add-deps" href="http://localhost/ci-crud/cadastro_dependente?id_func=<?php echo $emp[$i]['id']; ?>&nome_func=<?php echo $emp[$i]['nome']; ?>&cpf_func=<?php echo $emp[$i]['cpf']; ?>&departamento=<?php echo $emp[$i]['departamento']; ?>">
                            <div>Cadastrar dependente</div>
                        </a>

                        <!-- Tag 'a' to add a registered dependent -->
                        <button data-emp-name="<?php echo $emp[$i]['nome']; ?>" data-emp-id="<?php echo $emp[$i]['id']; ?>" type="button" class="add-deps" >Add Dep Cadastrado</button>

                        

                        <!-- Button to delete a employee -->
                        <button data-emp-id="<?php echo $emp[$i]['id']; ?>" data-emp-name="<?php echo $emp[$i]['nome']; ?>" data-emp-depart="<?php echo $emp[$i]['departamento']; ?>" data-emp-cpf="<?php echo $emp[$i]['cpf']; ?>" type="button" class="bttn-emp del-emp conf-del-emp">Excluir cadastro</button>

                        <!-- Tag 'a' to edit a employee -->
                        <a class="bttn-emp edit-emp" href="http://localhost/ci-crud/editar_cadastro?id=<?php echo $emp[$i]['id']; ?>&nome=<?php echo $emp[$i]['nome']; ?>&departamento=<?php echo $emp[$i]['departamento']; ?>&cpf=<?php echo $emp[$i]['cpf']; ?>&rua=<?php echo $emp[$i]['rua']; ?>&bairro=<?php echo $emp[$i]['bairro']; ?>&numero=<?php echo $emp[$i]['numero']; ?>&cidade=<?php echo $emp[$i]['cidade']; ?>&estado=<?php echo $emp[$i]['estadouf']; ?>"><div>Editar cadastro</div>
                        </a>
                        <div class="clear"></div>
                    </div> <!-- Employee Data: cpf, address, dependents] -->
                <?php } ?>
            </div> <!-- table-block -->
        </div> <!-- center -->

        <div class="reg-deps-wrapper">
            <div class="center">
                <div class="reg-deps-list">
                    <input type="text" name="searchdep" placeholder="Search..."/>
                    <table class="single-th">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CPF</th>
                        </tr>
                    </table>
                    <div class="deps-list-table"></div>
                </div> <!-- reg-deps-list -->
            </div> <!-- center:modf -->
        </div> <!-- reg-deps-wrapper -->
    </section>
    <div class="clear"></div>

</div> <!-- employees -->