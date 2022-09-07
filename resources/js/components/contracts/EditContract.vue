<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <strong>Editar contrato</strong>
                    </div>
                    <div class="card-body">

                        <ValidationObserver ref="form" v-slot="{ handleSubmit }">
                            <form @submit.prevent="handleSubmit(onSubmit)">

                                <ValidationProvider name="Nome do contratante" vid="contractor_name" rules="required"
                                                    :bails="false" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Nome do contratante *</label>
                                        <input type="text" class="form-control" v-model="contractor_name">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider name="E-mail do contratante" vid="contractor_email"
                                                    rules="required|email" :bails="false" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>E-mail do contratante *</label>
                                        <input type="text" class="form-control" v-model="contractor_email">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider name="Tipo de pessoa" vid="person_type" rules="required"
                                                    :bails="false" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Tipo de pessoa *</label>
                                        <select class="form-control" v-model="person_type">
                                            <option value="1" selected="selected">Pessoa Jurídica</option>
                                            <option value="2">Pessoa Física</option>
                                        </select>
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider name="Documento" vid="document" mode="lazy" rules="required"
                                                    :bails="false" v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Documento *</label>
                                        <input type="tel" class="form-control" id="document-input"
                                               v-model="document" v-mask="docMask" @blur="validateDocument">
                                        <span class="text-danger">{{ errors[0] }}</span>
                                    </div>
                                </ValidationProvider>

                                <ValidationProvider name="Imóvel" vid="property_id" rules="required" :bails="false"
                                                    v-slot="{ errors }">
                                    <div class="form-group">
                                        <label>Imóvel *</label>
                                        <select class="form-control" v-model="property_id">
                                            <option v-for="property in properties" v-bind:value="property.id">
                                                {{
                                                    `${property.street}, ${property.number}, ${property.complement}, ${property.district}`
                                                }}
                                            </option>
                                        </select>
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
import {mask} from 'vue-the-mask';
import Helper from '../../helper';

localize('pt_BR', pt_BR);

extend('required', required);
extend('email', email);

export default {
    directives: {mask},
    components: {
        ValidationObserver,
        ValidationProvider,
    },
    data() {
        return {
            contractor_name: '',
            contractor_email: '',
            document: '',
            person_type: '',
            property_id: '',
            properties: [],
            docError: '',
            contractProperty: {}
        }
    },
    computed: {
        docMask() {
            const personType = parseInt(this.$data.person_type);
            if (isNaN(personType)) {
                return "";
            }
            return personType === 1 ? "##.###.###/####-##" : "###.###.###-##";
        },
    },
    created() {

        this.axios
            .get(`${process.env.MIX_APP_URL}/api/contracts/${this.$route.params.uuid}/edit`)
            .then((response) => {
                this.contractor_name = response.data.contractor_name,
                    this.contractor_email = response.data.contractor_email,
                    this.document = response.data.document,
                    this.person_type = response.data.person_type,
                    this.property_id = response.data.property_id,
                    this.contractProperty = response.data.property
            });

        this.axios
            .get(process.env.MIX_APP_URL + '/api/properties/avaliable')
            .then(response => {
                this.properties = response.data;
                if (this.contractProperty) {
                    this.properties.push(this.contractProperty);
                }
            });
    },
    methods: {
        validateDocument() {

            const personType = parseInt(this.$data.person_type);
            let document = $("#document-input").val();
            this.docError = "";

            if (document.length <= 0) {
                return;
            }

            // remove a mascara
            document = Helper.unmaskText(document);

            // PJ
            if (personType === 1) {
                if (!Helper.validateCNPJ(document)) {
                    this.docError = "CNPJ inválido";
                }
            } else {
                // PF
                if (!Helper.validateCPF(document)) {
                    this.docError = "CPF inválido";
                }
            }

            if (this.docError.length > 0) {
                alert(this.docError);
            }
        },
        async onSubmit() {

            // retorna se o documento e invalido
            if (this.docError.length > 0) {
                this.$refs.form.setErrors({
                    document: [this.docError]
                });
                return;
            }

            const formData = {
                contractor_name: this.$data.contractor_name,
                contractor_email: this.$data.contractor_email,
                document: Helper.unmaskText(this.$data.document),
                person_type: this.$data.person_type,
                property_id: this.$data.property_id,
            };

            this.axios
                .put(`${process.env.MIX_APP_URL}/api/contracts/${this.$route.params.uuid}`, formData)
                .then((response) => {
                    this.$router.push({name: 'contracts'});
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
