<template>
    <form @submit.prevent="submitForm">
        <VCard>
            <VAlert class="rounded-b-0" v-if="this.alert.message" :type="this.alert.type">{{ this.alert.message }}
            </VAlert>

            <VCardTitle class="text-2xl font-weight-bold">
                {{ this.response.name }}
            </VCardTitle>

            <VRow class="pa-6">

                <VCol cols="6">
                    <VTextField
                        v-model="this.response.id"
                        autofocus
                        :value="this.response.id"
                        label="ID"
                        disabled
                        readonly
                        type="rea"
                        hidden="hidden"
                    />
                </VCol>
                <VCol cols="6">
                    <VTextField
                        v-model="this.response.name"
                        autofocus
                        :value="this.response.name"
                        label="Role Name"
                        type="text"
                    />
                </VCol>
                <VCol cols="6">
                    <VTextField
                        v-model="this.response.nick_name"
                        autofocus
                        :value="this.response.nick_name"
                        label="NickName"
                        type="text"
                    />
                </VCol>


                <VCol cols="6">
                    <VSelect
                        v-model="this.response.status"
                        autofocus
                        :items="this.statusItems"
                        item-value="id"
                        item-title="name"
                        label="Roles"
                        type="text"
                    />
                </VCol>

            </VRow>
            <VCardActions class="float-end">
                <VBtn type="submit" color="primary">Save</VBtn>
            </VCardActions>
        </VCard>
    </form>
</template>

<script>
import {useRoute} from "vue-router";
import axios from "axios";
import {mapGetters} from "vuex";

const route = useRoute();

export default {
    name: "Role",
    computed: {
        ...mapGetters(['statusItems']) // access using this.statusItems
    },
    data() {
        return {
            response: [],
            alert: {message: '', type: ''}
        };
    },
    methods: {
        getRole() {
            axios.get('/api/administrator/roles/role/' + this.$route.params.id)
                .then((response) => {
                    this.response = response.data.role;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        submitForm() {
            const formData = new FormData();
            formData.append('name', this.response.name);
            formData.append('nick_name', this.response.nick_name);
            formData.append('status', this.response.status);

            axios.post('/api/administrator/roles/role/update-role/' + this.$route.params.id, formData)
                .then((response) => {
                    this.alert = {message: response.data.message, type: 'success'};
                })
                .catch(error => {
                    const errorMessage = error.response?.data?.error || 'Error unknown';
                    this.alert = {message: errorMessage, type: 'error'};
                    this.getRole();
                });
        }
    },
    created() {
        this.getRole();
    },
};
</script>
