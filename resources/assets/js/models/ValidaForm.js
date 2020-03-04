/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ValidaForm {
    
    constructor() {
        this._mensagem;
        this._formulario;
    }
    
    validaFormulario(formulario = null) {
        
        var validado   = true;
        var texto      = '';
        
        if(!formulario) {
            this._formulario = $('input[required], select[required], textarea[required]');
        }else {
            this._formulario = $(`${formulario} input[required], ${formulario} select[required], ${formulario} textarea[required]`);
        }
        
        $.each(this._formulario, function(){

            if( !$(this).val() ) {
                
                validado = false;

                console.log($(this).parent().siblings('label'));
                
                if($(this).parent().siblings('label').text()){
                    if(texto.indexOf($(this).parent().siblings('label').text().replace("*","")) == -1) {
                        texto += "* O campo <b>"+ $(this).parent().siblings('label').text().replace("*","") + "</b> é obrigatório.<br>";
                    }
                }
                
                if($(this).parent().parent().siblings('label').text()){
                    if(texto.indexOf($(this).parent().parent().siblings('label').text().replace("*","")) == -1) {
                        texto += "* O campo <b>"+ $(this).parent().parent().siblings('label').text().replace("*","") + "</b> é obrigatório.<br>";
                    }
                }
                
                $(this).parent().parent().addClass('has-error').addClass('has-danger');
            }else {
                $(this).parent().parent().removeClass('has-error').removeClass('has-danger');
            }
        });
        
        if(!validado){
            this.setMensagem(texto);
        }
        
        return validado;
    }
    
    setMensagem(texto) {
        this._mensagem = texto;
    }
    
    getMensagem() {
        return this._mensagem;
    }
    
}

