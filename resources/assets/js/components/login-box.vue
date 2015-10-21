<template>
    <modal :show.sync="showModal" class="LoginBox Modal--LoginBox">
        <h3 slot="header">Connexion</h3>


        <div slot="body">

            <p>Afin de vous connecter à Laravel France, merci d'utiliser un des services externe suivant : </p>

            <ul class="LoginBox__Providers">
                <li class="LoginBox__Providers__Provider LoginBox__Providers__Provider--Google">
                    <a href="/socialite/google">Google</a>
                </li>
                <li class="LoginBox__Providers__Provider LoginBox__Providers__Provider--Github">
                    <a href="/socialite/github">Github</a>
                </li>
                <li class="LoginBox__Providers__Provider LoginBox__Providers__Provider--Twitter">
                    <a href="/socialite/twitter">Twitter</a>
                </li>
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