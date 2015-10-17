<template>
    <modal :show.sync="showModal" class="Modal--LoginBox">
        <h3 slot="header">Connexion</h3>

        <div slot="body">
            <ul class="">
                <li class=""><a href="/socialite/google">Google</a></li>
                <li class=""><a href="/socialite/github">Github</a></li>
                <li class=""><a href="/socialite/twitter">Twitter</a></li>
            </ul>
        </div>


        <div slot="footer"></div>


    </modal>
</template>

<script lang="es6" type="text/ecmascript-6">
    import Modal from './modal.vue'

    export default {
        components: {
           Modal
        },
        props: {
            showModal: {
                type: Boolean,
                default: false,
                twoWay: true
            }
        }
    }
</script>