<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestión de Usuarios</h3>
                    </div>
                    
                    <!-- Formulario -->
                    <div class="card-body">
                        <form @submit.prevent="guardarUsuario">
                            <div class="form-group mb-3">
                                <label>Correo</label>
                                <input 
                                    v-model="usuario.correo" 
                                    type="email" 
                                    class="form-control" 
                                    required
                                >
                            </div>
                            
                            <div class="form-group mb-3">
                                <label>Contraseña</label>
                                <input 
                                    v-model="usuario.password" 
                                    type="password" 
                                    class="form-control"
                                    :required="!editando"
                                >
                            </div>
                            
                            <div class="form-group mb-3">
                                <label>Rol</label>
                                <select v-model="usuario.rol_id" class="form-control" required>
                                    <option value="">Seleccione un rol</option>
                                    <option v-for="rol in roles" :key="rol.id" :value="rol.id">
                                        {{ rol.nombre }}
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ editando ? 'Actualizar' : 'Crear' }}
                            </button>
                            <button 
                                v-if="editando" 
                                @click="cancelarEdicion" 
                                type="button" 
                                class="btn btn-secondary ml-2"
                            >
                                Cancelar
                            </button>
                        </form>
                    </div>

                    <!-- Tabla de usuarios -->
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in usuarios" :key="user.id">
                                    <td>{{ user.correo }}</td>
                                    <td>{{ user.rol ? user.rol.nombre : 'Sin rol' }}</td>
                                    <td>
                                        <button 
                                            @click="editarUsuario(user)"
                                            class="btn btn-sm btn-info me-2"
                                        >
                                            Editar
                                        </button>
                                        <button 
                                            @click="eliminarUsuario(user.id)"
                                            class="btn btn-sm btn-danger"
                                        >
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'GestionUsuario',
    data() {
        return {
            usuarios: [],
            roles: [],
            usuario: {
                correo: '',
                password: '',
                rol_id: ''
            },
            editando: false
        }
    },
    mounted() {
        this.cargarUsuarios()
        this.cargarRoles()
    },
    methods: {
        async cargarUsuarios() {
            try {
                const response = await axios.get('/api/usuarios')
                this.usuarios = response.data
            } catch (error) {
                console.error('Error al cargar usuarios:', error)
            }
        },
        async cargarRoles() {
            try {
                const response = await axios.get('/api/roles')
                this.roles = response.data
            } catch (error) {
                console.error('Error al cargar roles:', error)
            }
        },
        async guardarUsuario() {
            try {
                if (this.editando) {
                    await axios.put(`/api/usuarios/${this.usuario.id}`, this.usuario)
                } else {
                    await axios.post('/api/usuarios', this.usuario)
                }
                this.limpiarFormulario()
                this.cargarUsuarios()
            } catch (error) {
                console.error('Error al guardar usuario:', error)
            }
        },
        editarUsuario(usuario) {
            this.usuario = {...usuario}
            this.editando = true
        },
        async eliminarUsuario(id) {
            if (!confirm('¿Está seguro de eliminar este usuario?')) return
            
            try {
                await axios.delete(`/api/usuarios/${id}`)
                this.cargarUsuarios()
            } catch (error) {
                console.error('Error al eliminar usuario:', error)
            }
        },
        limpiarFormulario() {
            this.usuario = {
                correo: '',
                password: '',
                rol_id: ''
            }
            this.editando = false
        },
        cancelarEdicion() {
            this.limpiarFormulario()
        }
    }
}
</script>