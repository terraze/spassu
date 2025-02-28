<div id="loading-overlay" class="position-fixed top-0 start-0 w-100 h-100 d-none" style="background: rgba(255,255,255,0.8); z-index: 1050;">
    <div class="position-absolute top-50 start-50 translate-middle text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
        <div class="mt-2">Carregando...</div>
    </div>
</div>

<script>
class LoadingOverlay {
    static MIN_TIME = 500; // Tempo mínimo de exibição da tela de carregamento
    static showTime = 0;

    static show() {
        this.showTime = Date.now();
        document.getElementById('loading-overlay').classList.remove('d-none');
    }

    static hide() {
        const elapsedTime = Date.now() - this.showTime;
        const remainingTime = Math.max(0, this.MIN_TIME - elapsedTime);

        // Se não mostramos por tempo mínimo, aguarde antes de ocultar
        if (remainingTime > 0) {
            setTimeout(() => {
                document.getElementById('loading-overlay').classList.add('d-none');
            }, remainingTime);
        } else {
            document.getElementById('loading-overlay').classList.add('d-none');
        }
    }
}

// Cria interceptadores do axios para mostrar/ocultar a tela de carregamento automaticamente
axios.interceptors.request.use(
    (config) => {
        LoadingOverlay.show();
        return config;
    },
    (error) => {
        LoadingOverlay.hide();
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    (response) => {
        LoadingOverlay.hide();
        return response;
    },
    (error) => {
        LoadingOverlay.hide();
        return Promise.reject(error);
    }
);

window.LoadingOverlay = LoadingOverlay;
</script> 