class DataTable {
    constructor(tableId, options = {}) {
        this.tableId = tableId;

        // Busca o elemento tbody da tabela usando o ID
        this.tableBody = document.querySelector(`#${tableId}`);

        // Define as opções padrão da tabela (permite sobrescrita via parâmetro)
        this.options = {
            apiUrl: options.apiUrl || '',                       // URL da API para buscar os dados
            rowTemplate: options.rowTemplate || null,           // Função para renderizar cada linha
            sortField: options.sortField || 'id',               // Campo padrão da ordenação
            sortDirection: options.sortDirection || 'asc'       // Direção padrão da ordenação
        };

        // Armazena o estado atual da ordenação
        this.currentSort = {
            field: this.options.sortField,      // Campo atual de ordenação
            direction: this.options.sortDirection // Direção atual (asc/desc)
        };

        // Inicia a configuração da tabela
        this.initialize();
    }

    // Inicializa o DataTable
    initialize() {
        this.setupSorting();
        this.loadData();
    }

    // Carrega os dados da API
    async loadData() {
        try {
            const response = await axios.get(this.options.apiUrl);
            if (response.status === 200) {
                const data = this.sortData(response.data);
                this.renderData(data);
            }
        } catch (error) {
            console.error('Erro ao carregar dados:', error);
            alert('Erro ao carregar os dados.');
        }
    }

    // Aplica ordenação nos dados com base na coluna e direção atual
    sortData(data) {
        return data.sort((a, b) => {
            const aValue = a[this.currentSort.field];
            const bValue = b[this.currentSort.field];
            return this.currentSort.direction === 'asc' 
                ? (aValue > bValue ? 1 : -1)
                : (aValue < bValue ? 1 : -1);
        });
    }

    // Renderiza as linhas da tabela
    renderData(data) {
        if (!this.tableBody) {
            console.error('Table body not found!');
            return;
        }

        const rows = data.map(item => this.options.rowTemplate(item)).join('');
        this.tableBody.innerHTML = rows;
    }

    // Aplica ordenação nas tableas que possuem a classe sortable
    setupSorting() {
        document.querySelectorAll(`#${this.tableId}-wrapper th.sortable`).forEach(header => {
            header.addEventListener('click', () => this.handleSort(header));
        });
    }

    // Função que lida com a ordenação das colunas
    handleSort(header) {
        const field = header.dataset.sort;
        if (!field) return;

        // Se a coluna clicada já está sendo ordenada, inverte a direção    
        if (this.currentSort.field === field) {
            this.currentSort.direction = this.currentSort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            // Se a coluna clicada não está sendo ordenada, define a direção como ascendente
            this.currentSort.field = field;
            this.currentSort.direction = 'asc';
        }

        // Remove a classe asc ou desc de todas as colunas
        document.querySelectorAll(`#${this.tableId}-wrapper th.sortable`).forEach(th => {
            th.classList.remove('asc', 'desc');
        });

        // Re-adiciona a classe asc ou desc à coluna clicada
        header.classList.add(this.currentSort.direction);

        this.loadData();
    }
} 