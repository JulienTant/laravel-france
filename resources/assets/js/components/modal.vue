<template>
    <div class="modal-mask" v-show="show" transition="modal">
        <div class="modal-wrapper">
            <div class="modal-container">
                <div class="modal-header">
                    <slot name="header">
                        Laravel France
                    </slot>
                </div>

                <div class="modal-body">
                    <slot name="body"></slot>
                </div>

                <div class="modal-footer">
                    <slot name="footer">
                        <button class="modal-default-button" @click="show = false">
                            OK
                        </button>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="es6" type="text/ecmascript-6">
    export default {
        props: {
            show: {
                type: Boolean,
                required: true,
                twoWay: true
            }
        }
    }
</script>