<template>
    <div>
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <strong>Editar imóvel</strong>
                    </div>
                    <div class="card-body">

                        <ValidationObserver ref="form" v-slot="{ handleSubmit }">
                            <form @submit.prevent="onSubmit">

                                <ValidationProvider name="E-mail do proprietário" vid="owner_email"
                                                    rules="required|email" :bails="false" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>E-mail do proprietário *</label>
                                        <input type="text" class="form-control" v-model="owner_email">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider name="Rua" vid="street" rules="required" :bails="false"
                                                    v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Rua *</label>
                                        <input type="text" class="form-control" v-model="street">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider name="Número" vid="number" :bails="false" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Número</label>
                                        <input type="number" class="form-control" v-model="number">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider name="Complemento" vid="complement" :bails="false"
                                                    v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Complemento</label>
                                        <input type="text" class="form-control" v-model="complement">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider name="Bairro" vid="district" rules="required" :bails="false"
                                                    v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Bairro *</label>
                                        <input type="text" class="form-control" v-model="district">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider name="Cidade" vid="city" rules="required" :bails="false"
                                                    v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Cidade *</label>
                                        <input type="text" class="form-control" v-model="city">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider name="Estado" vid="state" rules="required" :bails="false"
                                                    v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Estado *</label>
                                        <input type="text" class="form-control" v-model="state">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </form>
                        </ValidationObserver>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {ValidationProvider, ValidationObserver, extend, localize} from 'vee-validate';
import {required, email} from 'vee-validate/dist/rules';
import pt_BR from 'vee-validate/dist/locale/pt_BR.json';

localize('pt_BR', pt_BR);

extend('required', required);
extend('email', email);

export default {
    components: {
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
        }
    },
    created() {
        this.axios
            .get(`${process.env.MIX_APP_URL}/api/properties/${this.$route.params.uuid}/edit`)
            .then((response) => {
                this.owner_email = response.data.owner_email;
                this.street = response.data.street;
                this.number = response.data.number;
                this.complement = response.data.complement;
                this.district = response.data.district;
                this.city = response.data.city;
                this.state = response.data.state;
            });
    },
    methods: {
        onSubmit() {
            this.axios
                .put(`${process.env.MIX_APP_URL}/api/properties/${this.$route.params.uuid}`, this.$data)
                .then((response) => {
                    this.$router.push({name: 'properties'});
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.$refs.form.setErrors(error.response.data.errors);
                    }
                });
        }
    }
}
</script>
