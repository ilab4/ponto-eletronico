$(document).ready( function() {

    var dir_root = 'https://financeiro.protense.com.br';
    
    var cpf_cnpj_pre = $('#cnpj_cpf').val();
    var tipo_pre = $('#tipo').val();
    
    
    $('.datemask').mask('00/00/0000');
    $('.telefone').mask('(00) 0000-0000');
    $('.whats').mask('(00) 00000-0000');
    $('.cpf').mask('000.000.000-00');
    $('.cep').mask('00.000-000');
    $('.cnpj').mask('00.000.000/0000-00');
    $('.time').mask('00:00');
    $(".dinheiro").maskMoney({
        decimal: ",",
        thousands: "."
    });


    if(tipo_pre != ''){
        
        $('#box-dados').show();
        $('#box-cnpj-cpf').show();
        
        if(tipo_pre == 'Pessoa Fisica'){
            $('#box-pf').show();
            $('#box-pj').hide();
            $('#label-cnpj-cpf').html('CPF');
            $('#nome').attr("required", true);
            $('#razao_social').attr("required", false);
            $('#nome_fantasia').attr("required", false);
            $('#cnpj_cpf').mask('000.000.000-00');
        } else if(tipo_pre == 'Pessoa Juridica'){
            $('#box-pf').hide();
            $('#box-pj').show();
            $('#label-cnpj-cpf').html('CNPJ');
            $('#nome').attr("required", false);
            $('#razao_social').attr("required", true);
            $('#nome_fantasia').attr("required", true);
            $('#cnpj_cpf').mask('00.000.000/0000-00');
        }
        
        $('#box-submit').show();
        
    }

    $('#tipo').change(function(){

        var tipo = $('#tipo').val();

        if(tipo == 'Pessoa Fisica'){
            $('#label-cnpj-cpf').html('CPF');
            $('#cnpj_cpf').mask('000.000.000-00');
        } else if(tipo == 'Pessoa Juridica'){
            $('#label-cnpj-cpf').html('CNPJ');
            $('#cnpj_cpf').mask('00.000.000/0000-00');
        }
        
        $('#box-cnpj-cpf').show();
        $('#box-dados').show();
        $('#box-submit').show();
 
    });
    
    $('.parcelamento').change(function(){
        
        $('#box-msg-parcelamento').hide();
        
        var parcela = $('#parcela').val();
        
        if(parcela > 1){
            
            $('#msg-parcelamento').html('Frequência relativa a data de vencimento das parcelas');
            
        } else {
            $('#msg-parcelamento').html('Frequência relativa a programação de lançamentos');
            $('#box-msg-parcelamento').hide();
        }
        
        $('#box-msg-parcelamento').show();
 
    });
    
    
    $('#email').change(function(){

        var email = $('#email').val();
        //var _token = $('#_token').val();
        var _token = $("input[type=hidden][name=_token]").val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/ajaxEmail",
            dataType: 'json',
            data: {
                email: email,
                _token: _token
            },
            success: function(data) {
                $('#has-error-email').html('').hide();
                if(data > 1){
                    $('#has-error-email').html(' (Esse email já está sendo utilizado)').show();
                    $('#email').focus();
                    $('#btnCadastro').attr('disabled', 'disabled');
                    return false;
                } else {
                    $('#btnCadastro').removeAttr('disabled');
                }
            }
        });
    });

    $('#cep').change(function(){
        
        var cep = $('#cep').val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/ajaxCep",
            dataType: 'json',
            data: {
                cep: cep
            },
            success: function(data) {

                if(data.sucesso > 0){
                    $('#endereco').val(unescape(data.endereco));
                    $('#bairro').val(unescape(data.bairro));
                    $('#cidade').val(unescape(data.cidade));
                    $('#uf').val(unescape(data.uf));
                    $('#numero').focus();
                } 
            }
        });
    });
    
    $('.cnpj_cpf').change(function(){

        var cpf_cnpj = $('#cnpj_cpf').val();
        
        cpf = cpf_cnpj.replace(/\./g, "");
        cpf = cpf.replace(/-/g, "");
        cpf = cpf.replace(/\//g, "");
        
        if ( valida_cpf_cnpj(cpf) ) {
        
            $.ajax({
                type: "POST",
                url: dir_root + "/ajaxCpf",
                dataType: 'json',
                data: {
                    cnpj_cpf: cpf_cnpj
                },
                success: function(data) {
                    if(data > 1){    
                        $('#has-error-cpf').html(' (Esse CNPJ/CPF já está registrado) ').show();
                        $('#cnpj_cpf').focus();
                        $('#box-dados').hide();
                        $('#box-submit').hide();
                    } else {
                        $('#has-error-cpf').html('').show();
                        $('#cnpj_cpf').focus();
                        $('#box-dados').show();
                        $('#box-submit').show();
                        
                        
                        var tipo = $('#tipo').val();

                        if(tipo == 'Pessoa Fisica'){
                            $('#box-pf').show();
                            $('#box-pj').hide();
                            $('#nome').attr("required", true);
                            $('#razao_social').attr("required", false);
                            $('#nome_fantasia').attr("required", false);
                            $('#cnpj_cpf').mask('000.000.000-00');
                        } else if(tipo == 'Pessoa Juridica'){
                            $('#box-pf').hide();
                            $('#box-pj').show();
                            $('#nome').attr("required", false);
                            $('#razao_social').attr("required", true);
                            $('#nome_fantasia').attr("required", true);
                            $('#cnpj_cpf').mask('00.000.000/0000-00');
                        }

                    }
                }
            });
        
        } else {
            $('#has-error-cpf').html(' (CNPJ/CPF inválido) ').show();
        }

        
    });

    
    function Formata_Dinheiro(n) {
        return n.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
    }
       

    
    Number.prototype.formatMoney = function (c, d, t) {
        var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
  
   
})