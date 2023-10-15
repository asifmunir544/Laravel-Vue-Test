<template>
    <a title="Click to mark as favorite question (Click again to undo)"
       :class="classes" @click.prevent="toggle"
       >
        <i class="fa fa-star fa-2x"></i>
        <span class="favorites-count">{{count}}</span>
    </a>
</template>

<script>
export default {
    name: "Favorite",
    props: ['question'],
    data() {
        return {
            isFavorited : this.question.is_favorited,
            count: this.question.favorites_count,
            id: this.question.id
        }
    },
    computed: {
        classes() {
            return [
                'favorite', 'mt-2', 'text-decoration-none',
                !this.signedIn ? 'off' : (this.isFavorited ? 'favorited' : '')
            ]
        },
        endpoint () {
            return `/questions/${this.id}/favorites`
        },
        ///Defined in authorize.js
        // signedIn() {
        //     return window.Auth.signedIn;
        // }
    },
    methods: {
        toggle() {
            if(! this.signedIn) {
                this.$toast.warning("Please login to favorite this question", 'Warning', {
                    timeout: 3000,
                    position: 'bottomLeft'
                });
                return;
            }
            this.isFavorited ? this.destroy() : this.create();
        },
        destroy() {
            axios.delete(this.endpoint)
            .then(res => {
                this.count--;
                this.isFavorited = false;
                this.$toast.error("You have successfully unfavorited this question", 'Success', {
                    timeout: 3000,
                    position: 'topLeft'
                });
            })
        },
        create() {
            axios.post(this.endpoint)
            .then(res => {
                this.count++;
                this.isFavorited = true;
                this.$toast.success("You have successfully favorited this question", 'Success', {
                    timeout: 3000,
                    position: 'topLeft'
                });
            })
        }
    }
}
</script>

<style scoped>

</style>
