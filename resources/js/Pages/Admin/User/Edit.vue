<template>

    <head>
        <title>
            {{
                userData.lang_code == 'kz'
                    ? 'Админ панель | Қызметкер өзгерту'
                    : userData.lang_code == 'ru'
                        ? 'Админ панель | Изменить сотрудника'
                        : 'Yönetici Paneli | Personel  bilgileri'
            }}
        </title>
    </head>
    <AdminLayout>
        <template #breadcrumbs>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        {{
                            userData.lang_code == 'kz'
                                ? 'Қызметкер өзгерту'
                                : userData.lang_code == 'ru'
                                    ? 'Изменить сотрудника'
                                    : 'Personel bilgileri'
                        }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a :href="route('admin.index')">
                                <i class="fas fa-dashboard"></i>
                                {{
                                    userData.lang_code == 'kz'
                                        ? 'Басты бет'
                                        : userData.lang_code == 'ru'
                                            ? 'Главная'
                                            : 'Ana sayfa'
                                }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a :href="route('admin.users.index')">
                                <i class="fas fa-dashboard"></i>
                                {{
                                    userData.lang_code == 'kz'
                                        ? 'Қызметкерлер тізімі'
                                        : userData.lang_code == 'ru'
                                            ? 'Список сотрудников'
                                            : 'Personellerın listesi'
                                }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{
                                userData.lang_code == 'kz'
                                    ? 'Қызметкер өзгерту'
                                    : userData.lang_code == 'ru'
                                        ? 'Изменить сотрудника'
                                        : 'Personel bilgileri'
                            }}
                        </li>
                    </ol>
                </div>
            </div>
        </template>
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="post" @submit.prevent="submit">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">
                                {{
                                    userData.lang_code == 'kz'
                                        ? 'Аты'
                                        : userData.lang_code == 'ru'
                                            ? 'Имя'
                                            : 'Adı'
                                }}
                            </label>
                            <input type="text" class="form-control" v-model="user.name" name="name" />
                            <validation-error :field="'name'" />
                        </div>
                        <div class="form-group">
                            <label for="">
                                {{
                                    userData.lang_code == 'kz'
                                        ? 'Телефон номері'
                                        : userData.lang_code == 'ru'
                                            ? 'Телефон'
                                            : 'Telefon Numarası'
                                }}
                            </label>
                            <input type="text" class="form-control" v-model="user.phone" name="phone" />
                            <validation-error :field="'phone'" />
                        </div>
                        <div class="form-group">
                            <label for="">
                                {{
                                    userData.lang_code == 'kz'
                                        ? 'Почтасы'
                                        : userData.lang_code == 'ru'
                                            ? 'Почта'
                                            : 'E-posta'
                                }}
                            </label>
                            <input type="text" class="form-control" v-model="user.email" name="email" />
                            <validation-error :field="'email'" />
                        </div>
                        <div class="form-group">
                            <label for="">
                                {{
                                    userData.lang_code == 'kz'
                                        ? 'Құпия сөзі'
                                        : userData.lang_code == 'ru'
                                            ? 'Пароль'
                                            : 'Parola'
                                }}
                            </label>
                            <input type="text" class="form-control" v-model="user.real_password" name="real_password" />
                            <validation-error :field="'real_password'" />
                        </div>
                        <div class="form-group">
                            <label for="">
                                {{
                                    userData.lang_code == 'kz'
                                        ? 'Рөлдер'
                                        : userData.lang_code == 'ru'
                                            ? 'Роли'
                                            : 'Rolleri'
                                }}
                            </label>
                            <div class="ml33">
                                <multiselect v-model="user.selectedRoles" :options="filteredRoles" :multiple="true"
                                    :taggable="true"
                                    :placeholder="rolChoose"
                                    label="role_name" :hide-selected="true"
                                    :close-on-select="false" :searchable="false" track-by="roleID" class="mt-3 ml-3">
                                </multiselect>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-1">
                            {{
                                userData.lang_code == 'kz'
                                    ? 'Сақтау'
                                    : userData.lang_code == 'ru'
                                        ? 'Сохранить'
                                        : 'Kaydet'
                            }}
                        </button>
                        <button type="button" class="btn btn-danger" @click.prevent="back()">
                            {{
                                userData.lang_code == 'kz'
                                    ? 'Артқа'
                                    : userData.lang_code == 'ru'
                                        ? 'Назад'
                                        : 'Dönüş'
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
<script>
import AdminLayout from "../../../Layouts/AdminLayout.vue";
import { Link, Head } from "@inertiajs/inertia-vue3";
import Pagination from "../../../Components/Pagination.vue";
import ValidationError from "../../../Components/ValidationError.vue";

export default {
    components: {
        AdminLayout,
        Link,
        Pagination,
        ValidationError,
        Head
    },
    data() {
        return {

        }
    },
    mounted() {
        this.user.is_active = this.user.is_active ? true : false;
        this.user.selectedRoles = this.userRoles;
    },
    created() {
        this.$store.dispatch('fetchUser');
    },
    computed: {
        rolChoose() {
            return this.$store.getters.getUserData.user.lang_code === 'kz' ? 'Рөлдерді таңдаңыз' : 'Rolleri seçin'
        },
        userData() {
            return this.$store.getters.getUserData.user;
        },
        selectedRoleIds: function () {
            return this.user.selectedRoles.map(role => role.roleID);
        },
        filteredRoles() {
            let filtered = this.roles;
            return filtered;
        },
    },
    props: [
        'user',
        'roles',
        'userRoles',
    ],
    methods: {
        submit() {
            this.user.selectedRoles = this.selectedRoleIds;
            this.$inertia.put(
                route("admin.users.update", this.user.id),
                this.user
            );
        },
    },
};
</script>
<style lang="scss" scoped>
input.switch {
    -moz-appearance: none;
    -webkit-appearance: none;
    -o-appearance: none;
    appearance: none;
    height: 1em;
    width: 2em;
    border-radius: 1em;
    box-shadow: inset -1em 0px 0px 0px rgba(192, 192, 192, 1);
    background-color: white;
    border: 1px solid rgba(192, 192, 192, 1);
    outline: none;
    -webkit-transition: 0.2s;
    transition: 0.2s;
}

input.switch:checked {
    box-shadow: inset 1em 0px 0px 0px rgba(33, 150, 243, 0.5);
    border: 1px solid rgba(33, 150, 243, 1);
}

input.switch:focus {
    outline-width: 0;
}

.ml33 {
    margin-left: -1rem !important;
    margin-top: -1rem !important;
    margin-right: 1rem;
}
</style>