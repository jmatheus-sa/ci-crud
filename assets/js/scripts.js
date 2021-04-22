$(document).ready(function(){

    /**
     * Ajustar footer da página
     */
    var secNewEmpH = setHeight("newemployee");
    var secEmpsH = setHeight("employees");
    var secNewDepH = setHeight("newdependent");
    function setHeight(page){
        var pageHeight = $("."+page).height();
        if(isNaN(pageHeight)){
            return 0;
        }
        return pageHeight;
    }
    var adjOffset = $("footer").outerHeight(true) + $("header").height() + secNewEmpH + secEmpsH + secNewDepH;
    var offset = ($(window).height() - adjOffset) + "px";
    if($(document).outerHeight(true) <= $(window).height()){
        $("footer").css("top", offset);
    }

    // Slide na tabela de funcionários
    $("table.single-td-slide").click(function(){
        $(this).next().slideToggle("fast");
    });

    /**
     * Confirmação para cadastrar funcionário
     */
    $("#register-emp").click(function(){
        var confirmMsg;
        var confirmReg = confirm("Confirmar cadastro?");
        if(confirmReg == true){
            confirmMsg = "Funcionário cadastrado com sucesso";
            $("#form-register-emp").submit();
        }
    });

    /**
     * Confirmação para cadastrar dependente
     */
    $("#register-dep").click(function(){
        var confirmMsg;
        var confirmReg = confirm("Confirmar cadastro?");
        if(confirmReg == true){
            confirmMsg = "Dependente cadastro com sucesso";
            $("#form-register-dep").submit();
        }
    });

    /**
     * Confirmação para adicionar dependente cadastrado
     */
    // $("table.dep-list-single-td").click(function(){
    //     var el = $(this);
    //     var confirmMsg;
    //     var confirmAdd = confirm("Adicionar dependente " + el.data("depName") +
    //     " ao funcionário " + el.data("empName") + "?");
    //     if(confirmAdd == true){

    //     }
    // });

    /**
     * Botão para adicionar dependente cadastrado
     */
    $("button.add-deps").click(function(){
        var el = $(this);
        $(".reg-deps-wrapper").css("display","block");
        $(".reg-deps-wrapper input[name='searchdep']").attr("empname", el.data("empName"));
        $(".reg-deps-wrapper input[name='searchdep']").attr("empid", el.data("empId"));
    });
    
    // Fechar modal com "Esc"
    $(window).keydown(function(e){
        if($(".reg-deps-wrapper").css("display") == "block"){
            if(e.which == 27){
                $(".reg-deps-wrapper").css("display","none");
                $(".reg-deps-wrapper input[name='searchdep']").val("");
                $(".reg-deps-wrapper .deps-list-table").html("");
                $(".reg-deps-wrapper input[name='searchdep']").removeAttr("empname");
                $(".reg-deps-wrapper input[name='searchdep']").removeAttr("empid");
            }
        }
    })

    /**
     * Pesquisar dependente pelo nome
     */

    $(".reg-deps-wrapper input[name='searchdep']").keyup(function(){
        var el = $(this);
        var str = el.val();
        // $(".reg-deps-wrapper table").after(data);
        if(str.length != 0){
            $.get("http://localhost/Lti/depslist", {empName : el.attr("empname"), empId : el.attr("empid"), namesrc : str}, function(data){
                $(".reg-deps-wrapper .deps-list-table").html(data);
            });
        }else{
            $(".reg-deps-wrapper .deps-list-table").html("");
        }
    });

    /**
     * Confirmação para deletar funcionário
     */
    $(".conf-del-emp").click(function(){
        var el = $(this);
        var confirmMsg;
        var confirmDel = confirm("Confirmar exclusão de funcionário?\nID: " + el.data("empId") + "\nCPF: " + el.data("empCpf") + "\nNome: " +
        el.data("empName") + "\nDepartamento: " + el.data("empDepart"));
        if(confirmDel == true){
            confirmMsg = "Funcionário excluído com sucesso";
            window.location.replace("http://localhost/Lti/delEmployee/"+el.data("empId"));
        }
    });

    /**
     * Confirmação para deletar um dependente
     */
    $(".conf-del-dep").click(function(){
        var el = $(this);
        var confirmMsg;
        var confirmDel = confirm("Confirmar exclusão de dependente?\nID: " + el.data("empId") + "\nCPF: " + el.data("empCpf") + "\nNome: " +
        el.data("empName") + "\nDepartamento: " + el.data("empDepart") + "\nDependente: " + el.data("depName"));
        if(confirmDel == true){
            confirmMsg = "Dependente excluído com sucesso";
            window.location.replace(el.data("delUrl"));
        }
    });
    
});