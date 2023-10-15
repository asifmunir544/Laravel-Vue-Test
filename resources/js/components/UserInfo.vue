<template>
    <div>
        <span class="text-muted">{{postDate}}</span>
        <div class="d-flex mt-2">
            <div class="flex-shrink-0">
                <a :href="user.url">
                    <img :src="user.avatar" alt="...">
                </a>
            </div>
            <div class="flex-grow-1 ms-2">
                <a class="text-decoration-none" :href="user.url">{{user.name}}</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "UserInfo",
    props: ['model', 'label'],
    computed: {
        postDate () {
            return this.label + " " + this.model.created_date
        }
    },
    data() {
        return {
            user: this.model.user
        }
    }

}
</script>

<style scoped>

</style>
