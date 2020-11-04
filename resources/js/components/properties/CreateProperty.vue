<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <strong>Criar imóvel</strong>
                    </div>
                    <div class="card-body">

                        <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>

                        <ValidationObserver v-slot="{ handleSubmit }">
                            <form @submit.prevent="handleSubmit(onSubmit)">

                                <ValidationProvider name="E-mail do proprietário" rules="required|email" :bails="false" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>E-mail do proprietário *</label>
                                        <input type="text" class="form-control" v-model="owner_email">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider name="Rua" rules="required" :bails="false" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Rua *</label>
                                        <input type="text" class="form-control" v-model="street">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <div class="form-group">
                                    <label>Número</label>
                                    <input type="number" class="form-control" v-model="number">
                                </div>

                                <div class="form-group">
                                    <label>Complemento</label>
                                    <input type="text" class="form-control" v-model="complement">
                                </div>

                                <ValidationProvider name="Bairro" rules="required" :bails="false" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Bairro *</label>
                                        <input type="text" class="form-control" v-model="district">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>           
                                </ValidationProvider>
                                
                                <ValidationProvider name="Cidade" rules="required" :bails="false" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Cidade *</label>
                                        <input type="text" class="form-control" v-model="city">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>
                                
                                <ValidationProvider name="Estado" rules="required" :bails="false" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Estado *</label>
                                        <input type="text" class="form-control" v-model="state">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <button type="submit" class="btn btn-primary">Criar</button>
                            </form>
                        </ValidationObserver>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import ValidationErrors from '../ValidationErrors.vue';
    import { ValidationProvider, ValidationObserver, extend, localize } from 'vee-validate';
    import { required, email } from 'vee-validate/dist/rules';
    import pt_BR from 'vee-validate/dist/locale/pt_BR.json';

    localize('pt_BR', pt_BR);

    extend('required', required);
    extend('email', email);

    export default {
        components: {
            ValidationErrors,
            ValidationObserver,
            ValidationProvider,
        },
        data() {
            return {
                owner_email: '',
                street: '',
                number: '',
                complement: '',
                district: '',
                city: '',
                state: '',
                validationErrors: ''
            }
        },
        methods: {
            onSubmit () {
                this.axios
                    .post(process.env.MIX_APP_URL + '/api/properties', this.$data)
                    .then(response => (
                        this.$router.push({name: 'properties'})
                    ))
                    .catch(error => {
                        // Exibe erros do backend
                        if (error.response.status === 422) {
                            this.validationErrors = error.response.data.errors;
                        }
                    });
            }
        }
    }
</script>
