document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    let clients = [];
    let currentPage = 1;
    const clientsPerPage = 10;
    let clientToDelete = null;
    
    // Elementos del DOM
    const clientTableBody = document.getElementById('clientTableBody');
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const sortBy = document.getElementById('sortBy');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');
    const totalClientsSpan = document.getElementById('totalClients');
    const activeClientsSpan = document.getElementById('activeClients');
    const premiumClientsSpan = document.getElementById('premiumClients');
    const addClientBtn = document.getElementById('addClientBtn');
    const deleteModal = document.getElementById('deleteModal');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const closeModal = document.querySelector('.close-modal');
    
    // Inicialización
    loadSampleData();
    renderClientTable();
    updateStats();
    
    // Event Listeners
    searchInput.addEventListener('input', handleSearch);
    filterStatus.addEventListener('change', handleFilterChange);
    sortBy.addEventListener('change', handleSortChange);
    prevPageBtn.addEventListener('click', goToPrevPage);
    nextPageBtn.addEventListener('click', goToNextPage);
    addClientBtn.addEventListener('click', addNewClient);
    cancelDeleteBtn.addEventListener('click', closeDeleteModal);
    confirmDeleteBtn.addEventListener('click', confirmDelete);
    closeModal.addEventListener('click', closeDeleteModal);
    window.addEventListener('click', function(e) {
        if (e.target === deleteModal) {
            closeDeleteModal();
        }
    });
    
    // Funciones principales
    function loadSampleData() {
        // Datos de ejemplo - en una aplicación real esto vendría de una API
        clients = [
            {
                id: 1,
                firstName: "María",
                lastName: "González",
                email: "maria.gonzalez@example.com",
                phone: "(123) 456-7890",
                company: "Tech Solutions",
                type: "business",
                status: "active",
                lastActivity: "2023-05-15"
            },
            {
                id: 2,
                firstName: "Carlos",
                lastName: "Martínez",
                email: "carlos.martinez@example.com",
                phone: "(234) 567-8901",
                company: "Innova Corp",
                type: "premium",
                status: "active",
                lastActivity: "2023-05-18"
            },
            {
                id: 3,
                firstName: "Ana",
                lastName: "López",
                email: "ana.lopez@example.com",
                phone: "(345) 678-9012",
                company: "Design Studio",
                type: "individual",
                status: "inactive",
                lastActivity: "2023-04-22"
            },
            {
                id: 4,
                firstName: "Juan",
                lastName: "Rodríguez",
                email: "juan.rodriguez@example.com",
                phone: "(456) 789-0123",
                company: "Consulting Group",
                type: "business",
                status: "active",
                lastActivity: "2023-05-20"
            },
            {
                id: 5,
                firstName: "Laura",
                lastName: "Hernández",
                email: "laura.hernandez@example.com",
                phone: "(567) 890-1234",
                company: "Marketing Pro",
                type: "premium",
                status: "active",
                lastActivity: "2023-05-19"
            },
            {
                id: 6,
                firstName: "Pedro",
                lastName: "Gómez",
                email: "pedro.gomez@example.com",
                phone: "(678) 901-2345",
                company: "",
                type: "individual",
                status: "inactive",
                lastActivity: "2023-03-10"
            },
            {
                id: 7,
                firstName: "Sofía",
                lastName: "Díaz",
                email: "sofia.diaz@example.com",
                phone: "(789) 012-3456",
                company: "Legal Associates",
                type: "business",
                status: "active",
                lastActivity: "2023-05-17"
            },
            {
                id: 8,
                firstName: "Diego",
                lastName: "Pérez",
                email: "diego.perez@example.com",
                phone: "(890) 123-4567",
                company: "Financial Solutions",
                type: "premium",
                status: "active",
                lastActivity: "2023-05-21"
            },
            {
                id: 9,
                firstName: "Elena",
                lastName: "Sánchez",
                email: "elena.sanchez@example.com",
                phone: "(901) 234-5678",
                company: "",
                type: "individual",
                status: "inactive",
                lastActivity: "2023-02-28"
            },
            {
                id: 10,
                firstName: "Javier",
                lastName: "Ramírez",
                email: "javier.ramirez@example.com",
                phone: "(012) 345-6789",
                company: "Tech Innovators",
                type: "business",
                status: "active",
                lastActivity: "2023-05-16"
            },
            {
                id: 11,
                firstName: "Isabel",
                lastName: "Flores",
                email: "isabel.flores@example.com",
                phone: "(123) 456-7890",
                company: "Creative Minds",
                type: "premium",
                status: "active",
                lastActivity: "2023-05-22"
            },
            {
                id: 12,
                firstName: "Ricardo",
                lastName: "Vargas",
                email: "ricardo.vargas@example.com",
                phone: "(234) 567-8901",
                company: "",
                type: "individual",
                status: "inactive",
                lastActivity: "2023-01-15"
            }
        ];
    }
    
    function renderClientTable() {
        const filteredClients = filterClients();
        const sortedClients = sortClients(filteredClients);
        const paginatedClients = paginateClients(sortedClients);
        
        clientTableBody.innerHTML = '';
        
        if (paginatedClients.length === 0) {
            clientTableBody.innerHTML = `
                <tr>
                    <td colspan="7" class="no-results">
                        <i class="fas fa-info-circle"></i> No se encontraron clientes
                    </td>
                </tr>
            `;
            return;
        }
        
        paginatedClients.forEach(client => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${client.firstName} ${client.lastName}</td>
                <td>
                    <div>${client.email}</div>
                    <div class="text-muted">${client.phone}</div>
                </td>
                <td>${client.company || '-'}</td>
                <td>${getTypeLabel(client.type)}</td>
                <td><span class="client-status status-${client.status}">${getStatusLabel(client.status)}</span></td>
                <td>${formatDate(client.lastActivity)}</td>
                <td>
                    <div class="action-buttons">
                        <button class="action-btn view" data-id="${client.id}" title="Ver">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="action-btn edit" data-id="${client.id}" title="Editar">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn delete" data-id="${client.id}" title="Eliminar">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            `;
            clientTableBody.appendChild(row);
        });
        
        // Agregar event listeners a los botones de acción
        document.querySelectorAll('.action-btn.view').forEach(btn => {
            btn.addEventListener('click', viewClient);
        });
        
        document.querySelectorAll('.action-btn.edit').forEach(btn => {
            btn.addEventListener('click', editClient);
        });
        
        document.querySelectorAll('.action-btn.delete').forEach(btn => {
            btn.addEventListener('click', openDeleteModal);
        });
        
        updatePaginationControls(filteredClients.length);
    }
    
    function filterClients() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusFilter = filterStatus.value;
        
        return clients.filter(client => {
            const matchesSearch = 
                client.firstName.toLowerCase().includes(searchTerm) ||
                client.lastName.toLowerCase().includes(searchTerm) ||
                client.email.toLowerCase().includes(searchTerm) ||
                (client.company && client.company.toLowerCase().includes(searchTerm)) ||
                client.phone.includes(searchTerm);
            
            const matchesStatus = 
                statusFilter === 'all' || 
                (statusFilter === 'active' && client.status === 'active') ||
                (statusFilter === 'inactive' && client.status === 'inactive') ||
                (statusFilter === 'premium' && client.type === 'premium');
            
            return matchesSearch && matchesStatus;
        });
    }
    
    function sortClients(clientsArray) {
        const sortValue = sortBy.value;
        
        return [...clientsArray].sort((a, b) => {
            switch (sortValue) {
                case 'name-asc':
                    return `${a.firstName} ${a.lastName}`.localeCompare(`${b.firstName} ${b.lastName}`);
                case 'name-desc':
                    return `${b.firstName} ${b.lastName}`.localeCompare(`${a.firstName} ${a.lastName}`);
                case 'date-asc':
                    return new Date(a.lastActivity) - new Date(b.lastActivity);
                case 'date-desc':
                    return new Date(b.lastActivity) - new Date(a.lastActivity);
                default:
                    return 0;
            }
        });
    }
    
    function paginateClients(clientsArray) {
        const startIndex = (currentPage - 1) * clientsPerPage;
        return clientsArray.slice(startIndex, startIndex + clientsPerPage);
    }
    
    function updatePaginationControls(totalClients) {
        const totalPages = Math.ceil(totalClients / clientsPerPage);
        
        pageInfo.textContent = `Página ${currentPage} de ${totalPages}`;
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages || totalPages === 0;
    }
    
    function updateStats() {
        const total = clients.length;
        const active = clients.filter(c => c.status === 'active').length;
        const premium = clients.filter(c => c.type === 'premium').length;
        
        totalClientsSpan.textContent = total;
        activeClientsSpan.textContent = active;
        premiumClientsSpan.textContent = premium;
    }
    
    // Funciones de utilidad
    function getStatusLabel(status) {
        const labels = {
            active: 'Activo',
            inactive: 'Inactivo'
        };
        return labels[status] || status;
    }
    
    function getTypeLabel(type) {
        const labels = {
            individual: 'Individual',
            business: 'Empresarial',
            premium: 'Premium',
            government: 'Gubernamental'
        };
        return labels[type] || type;
    }
    
    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        return new Date(dateString).toLocaleDateString('es-ES', options);
    }
    
    // Handlers de eventos
    function handleSearch() {
        currentPage = 1;
        renderClientTable();
    }
    
    function handleFilterChange() {
        currentPage = 1;
        renderClientTable();
    }
    
    function handleSortChange() {
        renderClientTable();
    }
    
    function goToPrevPage() {
        if (currentPage > 1) {
            currentPage--;
            renderClientTable();
        }
    }
    
    function goToNextPage() {
        const filteredClients = filterClients();
        const totalPages = Math.ceil(filteredClients.length / clientsPerPage);
        
        if (currentPage < totalPages) {
            currentPage++;
            renderClientTable();
        }
    }
    
    function addNewClient() {
        // En una aplicación real, redirigiría al formulario de creación
        alert('Redirigiendo al formulario de nuevo cliente');
        // window.location.href = 'client-form.html';
    }
    
    function viewClient(e) {
        const clientId = parseInt(e.currentTarget.getAttribute('data-id'));
        const client = clients.find(c => c.id === clientId);
        alert(`Viendo cliente: ${client.firstName} ${client.lastName}\nEmail: ${client.email}`);
    }
    
    function editClient(e) {
        const clientId = parseInt(e.currentTarget.getAttribute('data-id'));
        const client = clients.find(c => c.id === clientId);
        alert(`Editando cliente: ${client.firstName} ${client.lastName}`);
        // window.location.href = `client-form.html?id=${clientId}`;
    }
    
    function openDeleteModal(e) {
        clientToDelete = parseInt(e.currentTarget.getAttribute('data-id'));
        deleteModal.style.display = 'flex';
    }
    
    function closeDeleteModal() {
        deleteModal.style.display = 'none';
        clientToDelete = null;
    }
    
    function confirmDelete() {
        if (clientToDelete) {
            // En una aplicación real, haríamos una llamada API aquí
            clients = clients.filter(client => client.id !== clientToDelete);
            renderClientTable();
            updateStats();
            closeDeleteModal();
            
            // Mostrar mensaje de éxito
            alert('Cliente eliminado correctamente');
        }
    }
});