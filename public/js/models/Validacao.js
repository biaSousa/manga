/**
 * O input deve ser filho de form-group e deve ter o primeiro irmão um span
 * com glyphicon
 *
 * <div class="form-group">
 <label for="cpf" class="control-label">C.P.F</label>
 <input type="text" id="cpf" name="cpf" class="form-control" placeholder="apenas números"
 tabindex="4" required value="{{$guia->cpf}}" onchange="oAntecedente.validar(this)" aria-describedby="cpfStatus">
 <span class="glyphicon glyphicon-ok form-control-feedback hidden" aria-hidden="true"></span>
 </div>
 */
class Validacao
{
    static sucesso(e)
    {
        let parent = e.parentNode;
        parent.classList.add('has-feedback');

        let span = parent.querySelector('span');
        span.classList.remove('hidden');

        parent.classList.add('has-success');
        parent.classList.remove('has-error');

        span.classList.add('glyphicon-ok');
        span.classList.remove('glyphicon-remove');

        let a = parent.querySelector('.help-block');
        if(a !== null)
            a.classList.add('hidden');
    }

    static erro(e, msg)
    {
        let parent = e.parentNode;
        parent.classList.add('has-feedback');

        let span = parent.querySelector('span');
        span.classList.remove('hidden');

        parent.classList.add('has-error');
        parent.classList.remove('has-success');

        span.classList.add('glyphicon-remove');
        span.classList.remove('glyphicon-ok');

        let a = parent.querySelector('.help-block');

        if(a !== null)
            a.classList.remove('hidden');

        if(typeof msg !== 'undefined')
            a.textContent = msg;
    }
}