@extends('app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Assuntos</h1>
    <a href="{{ route('assuntos.cadastro') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Novo Assunto
    </a>
</div>

@component('components.table', [
    'tableId' => 'assuntos-table',
    'headers' => [
        ['label' => 'Código', 'field' => 'CodAs'],
        ['label' => 'Descrição', 'field' => 'Descricao'],
        ['label' => 'Ações', 'field' => null]
    ]
])
@endcomponent

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('#assuntos-table');
    let currentSort = { field: 'CodAs', direction: 'asc' };

    // Function to load and display data
    async function loadAssuntos() {
        try {
            const response = await axios.get('/api/assuntos');
            console.log('Response:', response.data);

            if (response.status === 200) {
                let assuntos = response.data;
                console.log('Assuntos:', assuntos);
                
                // Sort data
                assuntos.sort((a, b) => {
                    const aValue = a[currentSort.field];
                    const bValue = b[currentSort.field];
                    return currentSort.direction === 'asc' 
                        ? (aValue > bValue ? 1 : -1)
                        : (aValue < bValue ? 1 : -1);
                });

                // Render table
                if (tableBody) {
                    console.log('Table body found');
                    tableBody.innerHTML = assuntos.map(assunto => `
                        <tr>
                            <td>${assunto.CodAs}</td>
                            <td>${assunto.Descricao}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="editarAssunto(${assunto.CodAs})">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="excluirAssunto(${assunto.CodAs})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `).join('');
                } else {
                    console.error('Table body not found!');
                }
            }
        } catch (error) {
            console.error('Erro ao carregar assuntos:', error);
            alert('Erro ao carregar a lista de assuntos.');
        }
    }

    // Handle sorting
    document.querySelectorAll('th.sortable').forEach(header => {
        header.addEventListener('click', function() {
            const field = this.dataset.sort;
            if (!field) return;

            // Update sort direction
            if (currentSort.field === field) {
                currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
            } else {
                currentSort.field = field;
                currentSort.direction = 'asc';
            }

            // Update sort icons
            document.querySelectorAll('th.sortable').forEach(th => {
                th.classList.remove('asc', 'desc');
            });
            this.classList.add(currentSort.direction);

            // Reload data with new sorting
            loadAssuntos();
        });
    });

    // Initial load
    loadAssuntos();
});

// Placeholder functions for edit and delete
function editarAssunto(id) {
    window.location.href = `/assuntos/cadastro/${id}`;
}

function excluirAssunto(id) {
    if (confirm('Tem certeza que deseja excluir este assunto?')) {
        axios.delete(`/api/assuntos/${id}`)
            .then(response => {
                if (response.data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Erro ao excluir assunto:', error);
                alert('Erro ao excluir o assunto.');
            });
    }
}
</script>
@endpush
@endsection 