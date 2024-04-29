<template>
    <div class="row">

        <aside class="sidebar" :class="{ 'collapsed': isCollapsed }">
            <div class="custom-image">
                <img class="custom-image" :src="require('@/assets/logo5.png')" />
            </div>
            <br>
            <div class="search-bar">

                <input v-if="isCollapsed !== true" type="text" v-model="searchQuery" placeholder="Buscar... " />
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <ul>
                <li v-for="item in menuItems" :key="item.id" @click="cerrarSesion(item)">
                    <i :class="item.icon"></i>
                    <span>{{ item.label }}</span>
                </li>
            </ul>
            <button class="toggle-button" @click="toggleMenu">
                <i class="bi bi-chevron-double-right" v-if="isCollapsed"></i>
                <i class="bi bi-chevron-double-left" v-else></i>
            </button>
            <template>

            </template>
        </aside>
    </div>
</template>

<script>

export default {
    data() {
        return {
            searchQuery: '',
            isCollapsed: false,
            menuItems: [
                { id: 1, label: 'Inicio', icon: 'bi bi-house-door' },
                { id: 2, label: 'Participantes', icon: 'bi bi-person' },
                { id: 3, label: 'Usuarios', icon: 'bi bi-people' },
                { id: 5, label: 'Preselecciones', icon: 'bi bi-clock' },
                { id: 5, label: 'Cursos', icon: 'bi bi-book-fill' },
                { id: 4, label: 'Cerrar Sesión', icon: 'bi bi-box-arrow-right', class: "toggle-button" },


            ],
        };
    },
    methods: {
        cerrarSesion(item) {
            if (item.label === 'Cerrar Sesión') {
                localStorage.removeItem('token');
                this.$router.push('/');
            } else {

                const route = `/${item.label.toLowerCase()}`;
                this.$router.push(route);

            }
        },

        toggleMenu() {
            this.isCollapsed = !this.isCollapsed;
            this.$emit('collapsed-updated', this.isCollapsed);
        },
    },
};
</script>
  
<style scoped>
.custom-image {
    height: 100px;
    margin-top: 10%;
    padding-right: 30%;
}

.sidebar {
    width: 200px;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #041B2D;
    color: #fff;
    overflow-y: auto;
    transition: width 0.3s;
    z-index: 1;

}

.collapsed {
    width: 57px;
}

.search-bar {
    padding: 0px;
    margin-top: 20%;
}

.search-bar input {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 30px;
    background-color: #444;
    color: #fff;
}

ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

li {
    display: flex;
    align-items: center;
    padding: 15px;
    padding-left: 0;
    cursor: pointer;
    transition: background-color 0.2s;
    border-radius: 30px;
}

li:hover {
    background-color: #444;
    border-radius: 30px;
}

i {
    margin-right: 19px;
    padding-left: 10px;
}

.toggle-button {
    position: absolute;
    bottom: 20px;
    left: 1px;
    background-color: #444;
    border: none;
    border-radius: 5px;
    padding: 5px;
    cursor: pointer;
    color: #fff;
}
</style>
  