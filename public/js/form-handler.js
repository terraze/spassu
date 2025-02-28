class FormHandler {
    constructor(config) {
        this.formId = config.formId;
        this.apiUrl = config.apiUrl;
        this.idField = config.idField;
        this.successRedirect = config.successRedirect;
        this.form = document.getElementById(this.formId);
        
        this.setupFormSubmit();
    }

    setupFormSubmit() {
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const formData = new FormData(this.form);
            const data = Object.fromEntries(formData);
            
            LoadingOverlay.show();
            
            const id = data[this.idField];
            const method = id ? 'PUT' : 'POST';
            const url = id ? `${this.apiUrl}/${id}` : this.apiUrl;
            
            axios({
                method,
                url,
                data
            })
            .then(response => {
                Toast.show('Registro salvo com sucesso!', 'success');
                window.location.href = this.successRedirect;
            })
            .catch(error => {
                console.error('Erro ao salvar:', error);
                
                if (error.response?.status === 400) {
                    const errors = error.response.data.errors;
                    Object.keys(errors).forEach(field => {
                        const input = document.getElementById(field);
                        if (input) {
                            input.classList.add('is-invalid');
                            const feedback = input.nextElementSibling;
                            if (feedback && feedback.classList.contains('invalid-feedback')) {
                                feedback.textContent = errors[field][0];
                            }
                        }
                    });
                } else {
                    Toast.show('Erro ao salvar. Tente novamente.', 'error');
                }
            })
            .finally(() => {
                LoadingOverlay.hide();
            });
        });
    }
} 