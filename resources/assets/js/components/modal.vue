<template>
    <div class="Modal {{* class }}" v-show="show" transition="Modal" @click="clickOnMask">
        <div class="Modal__Wrapper" @click="clickOnMask">
            <div class="Modal__Wrapper__Container">
                <div class="Modal__Wrapper__Container__Header">
                    <slot name="header">
                        Laravel France
                    </slot>
                </div>

                <div class="Modal__Wrapper__Container__Body">
                    <slot name="body"></slot>
                </div>

                <div class="Modal__Wrapper__Container__Footer">
                    <slot name="footer">
                        <button @click="show = false">
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
        methods: {
            clickOnMask(e) {
                e.stopPropagation();
                if (e.target != e.currentTarget) return;

                this.show = false;
            }
        },
        props: {
            class: {
                type: String
            },
            show: {
                type: Boolean,
                required: true,
                twoWay: true
            }
        }
    }
</script>