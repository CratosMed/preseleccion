<template>
    <div :class='contentClass'>
        <MenuLateral @collapsed-updated="updateCollapsed" v-if="showSidebar" />
        <formpartVue />
        <Footer />
    </div>
</template>

<script>
import MenuLateral from '@/components/MenuLateral.vue';
import FormpartVue from '@/components/FormpartVue.vue';
import Footer from '@/components/FooterVue.vue';


export default {
    name: "EditarVue",
    data() {
        return {
            showSidebar: true,
            isCollapsed: false,
        }
    },
    components: {
        Footer,
        FormpartVue,
        MenuLateral

    },
    computed: {
        contentClass() {
            return this.isCollapsed ? 'full' : 'collap';
        },
    },

    methods: {
        updateCollapsed(value) {
            this.isCollapsed = value;
        },

    },
} 
</script>

<style>
.full {
    width: 100%;
    padding-left: 97px;
    padding-right: 40px;
}

.collap {
    width: 100%;
    padding-left: 251px;
    padding-right: 50px;
}
</style>