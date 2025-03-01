class TableHandler {
    constructor(config) {
        this.tableId = config.tableId;
        this.apiUrl = config.apiUrl;
        this.resourceName = config.resourceName;
        this.idField = config.idField;
        this.editRoute = config.editRoute;
        this.displayField = config.displayField;
        
        this.setupDataTable(config);
    }

    setupDataTable(config) {
        this.dataTable = new DataTable(this.tableId, {
            apiUrl: this.apiUrl,
            sortField: this.idField,
            rowTemplate: config.rowTemplate || this.defaultRowTemplate.bind(this)
        });
    }

    defaultRowTemplate(item) {
        return `
            <tr>
                <td>${item[this.idField]}</td>
                <td>${item[this.displayField]}</td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="tableHandler.edit(${item[this.idField]})">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="tableHandler.delete(${item[this.idField]}, '${item[this.displayField]}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    }

    edit(id) {
        window.location.href = `${this.editRoute}/${id}`;
    }

    delete(id, displayName) {
        if (confirm(`Tem certeza que deseja excluir ${this.resourceName} "${displayName}"?`)) {
            axios.delete(`${this.apiUrl}/${id}`)
                .then(response => {
                    if (response.status === 200) {
                        Toast.show(`${this.resourceName} excluído com sucesso!`, 'success');
                        this.dataTable.loadData();
                    }
                })
                .catch(error => {
                    let mensagem = `Erro ao excluir ${this.resourceName}.`;
                    
                    if (error.response?.status === 404) {
                        mensagem = `${this.resourceName} não encontrado.`;
                    } else if (error.response?.data?.message) {
                        mensagem = error.response.data.message;
                    }
                    
                    Toast.show(mensagem, 'error');
                });
        }
    }
} 