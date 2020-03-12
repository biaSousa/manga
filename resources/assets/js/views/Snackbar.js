/**
 * @requires app/view/Mensagem.js
 */
class Snackbar {
    
    constructor(conf)
    {
        this._snackbar = document.getElementById("snackbar");
        if(this._snackbar === null) {
            alert('Sr programador, a div snackbar não foi encontrada nesta página');
            return;
        }
        this._msg = document.getElementById('msg');
        this._snackbar.className = 'alert';
        this._snackbar.style.left = '35%';
        this._snackbar.style.top = '30px';
        
        this._snackbar.querySelector('.close').addEventListener('click', () => {
            this._snackbar.classList.remove("show");
            this._snackbar.classList.remove("show_stop");
        });


        //limpando todos os elementos com erro
        let elementos = document.querySelectorAll('.has-error');
        for(let i = 0; i < elementos.length; i++) {
            elementos[i].classList.remove('has-error');
        }
    }

    exibirVerde(msg, ocultar = true)
    {
        let mensagem = new Mensagem(msg);

        this.limparClasse();
        this._snackbar.classList.add('alert-success');
        // this.configurarMensagem(mensagem, this._snackbar, ocultar);
        return Reflect.apply(this.configurarMensagem, this, [mensagem, ocultar]);
    }

    exibirAmarelo(msg, ocultar = true)
    {
        let mensagem = new Mensagem(msg);

        this.limparClasse();
        this._snackbar.classList.add('alert-warning');
        // this.configurarMensagem(mensagem, this._snackbar, ocultar);
        return Reflect.apply(this.configurarMensagem, this, [mensagem, ocultar]);
    }

    exibirVermelho(msg, ocultar = true)
    {
        let mensagem = new Mensagem(msg);
        
        this.limparClasse();
        this._snackbar.classList.add('alert-danger');

        return Reflect.apply(this.configurarMensagem, this, [mensagem, ocultar]);
        // this.configurarMensagem(mensagem, this._snackbar, ocultar);
    }

    exibirAzul(msg, ocultar = true)
    {
        let mensagem = new Mensagem(msg);

        this.limparClasse();
        this._snackbar.classList.add('alert-info');
        // this.configurarMensagem(mensagem, this._snackbar, ocultar);
        return Reflect.apply(this.configurarMensagem, this, [mensagem, ocultar]);
    }

    limparClasse()
    {
        this._snackbar.classList.remove('alert-info');
        this._snackbar.classList.remove('alert-warning');
        this._snackbar.classList.remove('alert-danger');
        this._snackbar.classList.remove('alert-success');
    }

    configurarMensagem(mensagem, ocultar = true)
    {
        this._msg.innerHTML = mensagem;

        //percorrendo a lista de ids para deixá-los em destaque
        if(mensagem.erroValidacao()) {//verifica se possui erro de validação
         
            for(let x in mensagem.getErros()) {//deixa o input com erro vermelho
                document.getElementById(x).parentNode.classList.add('has-error');
            }
        }

        if(ocultar) {
            this._snackbar.classList.add('show');
            setTimeout(() => { this._snackbar.classList.remove('show'); }, 5000);//deve ser a soma de fadeout + tempo de exibição da animação (está no css)
        }
        //se estiver setado para não sumir automaticamente, então habilita a movimentação manual da caixa de mensagem
        else {
            this._snackbar.classList.add('show_stop');

            let mousePosition;
            let offset = [0,0];
            let isDown = false;

            this._snackbar.addEventListener('mousedown', (e) => {
                isDown = true;
                offset = [
                    this._snackbar.offsetLeft - e.clientX,
                    this._snackbar.offsetTop - e.clientY
                ];
            }, true);

            document.addEventListener('mouseup', () => {
                isDown = false;
            }, true);

            document.addEventListener('mousemove', (event) => {
                event.preventDefault();
                if (isDown) {
                    mousePosition = {
                
                        x : event.clientX,
                        y : event.clientY
                
                    };
                    this._snackbar.style.left = (mousePosition.x + offset[0]) + 'px';
                    this._snackbar.style.top  = (mousePosition.y + offset[1]) + 'px';
                }
            }, true);
        }
    }
}