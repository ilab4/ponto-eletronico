$(document).ready( function() {

    var dir_root = $('#url_base').val();
    
    //PERGUNTA 1
    $('#pergunta1').change(function(){
        
        var pergunta = $('#pergunta1').val();
        var _token = $('#_token').val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/ajaxPesquisa",
            dataType: 'json',
            data: {
                pergunta: pergunta,
                _token: _token
            },
            success: function(data) {
                if(data.length > 0){
                    var options = '<option value="">Selecione Resposta</option>';
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                    }
                    $('#resposta1').html(options).show();
                } 
            }
        });
    });
    
    
    //PERGUNTA 2
    $('#pergunta2').change(function(){
        
        var pergunta = $('#pergunta2').val();
        var _token = $('#_token').val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/ajaxPesquisa",
            dataType: 'json',
            data: {
                pergunta: pergunta,
                _token: _token
            },
            success: function(data) {
                if(data.length > 0){
                    var options = '<option value="">Selecione Resposta</option>';
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                    }
                    $('#resposta2').html(options).show();
                } 
            }
        });
    });
    
    
    //PERGUNTA 3
    $('#pergunta3').change(function(){
        
        var pergunta = $('#pergunta3').val();
        var _token = $('#_token').val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/ajaxPesquisa",
            dataType: 'json',
            data: {
                pergunta: pergunta,
                _token: _token
            },
            success: function(data) {
                if(data.length > 0){
                    var options = '<option value="">Selecione Resposta</option>';
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                    }
                    $('#resposta3').html(options).show();
                } 
            }
        });
    });
    
    
    //PERGUNTA 4
    $('#pergunta4').change(function(){
        
        var pergunta = $('#pergunta4').val();
        var _token = $('#_token').val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/ajaxPesquisa",
            dataType: 'json',
            data: {
                pergunta: pergunta,
                _token: _token
            },
            success: function(data) {
                if(data.length > 0){
                    var options = '<option value="">Selecione Resposta</option>';
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                    }
                    $('#resposta4').html(options).show();
                } 
            }
        });
    });
    
    
    //PERGUNTA 5
    $('#pergunta5').change(function(){
        
        var pergunta = $('#pergunta5').val();
        var _token = $('#_token').val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/ajaxPesquisa",
            dataType: 'json',
            data: {
                pergunta: pergunta,
                _token: _token
            },
            success: function(data) {
                if(data.length > 0){
                    var options = '<option value="">Selecione Resposta</option>';
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                    }
                    $('#resposta5').html(options).show();
                } 
            }
        });
    });
    
    
    //PERGUNTA 6
    $('#pergunta6').change(function(){
        
        var pergunta = $('#pergunta6').val();
        var _token = $('#_token').val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/ajaxPesquisa",
            dataType: 'json',
            data: {
                pergunta: pergunta,
                _token: _token
            },
            success: function(data) {
                if(data.length > 0){
                    var options = '<option value="">Selecione Resposta</option>';
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                    }
                    $('#resposta6').html(options).show();
                } 
            }
        });
    });
    
    
    //PERGUNTA 7
    $('#pergunta7').change(function(){
        
        var pergunta = $('#pergunta7').val();
        var _token = $('#_token').val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/ajaxPesquisa",
            dataType: 'json',
            data: {
                pergunta: pergunta,
                _token: _token
            },
            success: function(data) {
                if(data.length > 0){
                    var options = '<option value="">Selecione Resposta</option>';
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                    }
                    $('#resposta7').html(options).show();
                } 
            }
        });
    });
    
    
    //PERGUNTA 8
    $('#pergunta8').change(function(){
        
        var pergunta = $('#pergunta8').val();
        var _token = $('#_token').val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/ajaxPesquisa",
            dataType: 'json',
            data: {
                pergunta: pergunta,
                _token: _token
            },
            success: function(data) {
                if(data.length > 0){
                    var options = '<option value="">Selecione Resposta</option>';
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                    }
                    $('#resposta8').html(options).show();
                } 
            }
        });
    });
    
    
    //PERGUNTA 9
    $('#pergunta9').change(function(){
        
        var pergunta = $('#pergunta9').val();
        var _token = $('#_token').val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/ajaxPesquisa",
            dataType: 'json',
            data: {
                pergunta: pergunta,
                _token: _token
            },
            success: function(data) {
                if(data.length > 0){
                    var options = '<option value="">Selecione Resposta</option>';
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                    }
                    $('#resposta9').html(options).show();
                } 
            }
        });
    });
    
    
    //PERGUNTA 10
    $('#pergunta10').change(function(){
        
        var pergunta = $('#pergunta10').val();
        var _token = $('#_token').val();
        
        $.ajax({
            type: "POST",
            url: dir_root + "/ajaxPesquisa",
            dataType: 'json',
            data: {
                pergunta: pergunta,
                _token: _token
            },
            success: function(data) {
                if(data.length > 0){
                    var options = '<option value="">Selecione Resposta</option>';
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].nome + '">' + data[i].nome + '</option>';
                    }
                    $('#resposta10').html(options).show();
                } 
            }
        });
    });
    
    
    
    
   
})