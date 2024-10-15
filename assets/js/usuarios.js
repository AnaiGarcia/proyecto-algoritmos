const initialUsers = [
  { id: 1, name: "Juan Pérez", email: "juan@gmail.com", role: "Admin" },
  { id: 2, name: "María García", email: "maria@gmail.com", role: "Técnico" },
  { id: 3, name: "Carlos López", email: "carlos@gmail.com", role: "Técnico" },
  { id: 4, name: "Enrique Zapata", email: "enrique@gmail.com", role: "Operador" },
];

let selectedUser = null;

function renderUsers() {
  const userTableBody = document.getElementById('userTableBody');
  userTableBody.innerHTML = '';

  initialUsers.forEach((user) => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${user.name}</td>
      <td>${user.email}</td>
      <td>${user.role}</td>
      <td>
        <button class="btn" onclick="modifyUser(${user.id})">Editar</button>
        <button class="btn" onclick="deleteUser(${user.id})">Eliminar</button>
      </td>
    `;
    userTableBody.appendChild(row);
  });
}

function modifyUser(userId) {
  selectedUser = initialUsers.find(user => user.id === userId);
  if (selectedUser) {
    document.getElementById('userName').value = selectedUser.name;
    document.getElementById('userEmail').value = selectedUser.email;
    document.getElementById('userRole').value = selectedUser.role;
    document.getElementById('modifyUserForm').classList.remove('hidden');
  }
}

function deleteUser(userId) {
  const userIndex = initialUsers.findIndex(user => user.id === userId);
  if (userIndex > -1) {
    initialUsers.splice(userIndex, 1);
    renderUsers();
  }
}

document.getElementById('addUserBtn').addEventListener('click', () => {
  document.getElementById('modifyUserForm').classList.remove('hidden');
  document.getElementById('userName').value = '';
  document.getElementById('userEmail').value = '';
  document.getElementById('userRole').value = '';
  document.getElementById('formTitle').textContent = 'Agregar Nuevo Usuario';
  selectedUser = null;
});
document.getElementById('cancelBtn').addEventListener('click', () => {
  document.getElementById('modifyUserForm').classList.add('hidden');
  selectedUser = null;
});

document.getElementById('saveChangesBtn').addEventListener('click', () => {
  if (selectedUser) {
    selectedUser.name = document.getElementById('userName').value;
    selectedUser.email = document.getElementById('userEmail').value;
    selectedUser.role = document.getElementById('userRole').value;
  } else {
    const newUser = {
      id: initialUsers.length + 1,
      name: document.getElementById('userName').value,
      email: document.getElementById('userEmail').value,
      role: document.getElementById('userRole').value,
    };
    initialUsers.push(newUser);
  }
  
  renderUsers();
  document.getElementById('modifyUserForm').classList.add('hidden');
});

renderUsers();