<template>
    <div>
        <el-main>
            <el-row type="flex" class="row-bg" justify="center">
                <el-col :xs="24" :sm="24" :md="20" :lg="20" :xl="20">
                    <div style="text-align: right">
                        <el-button type="primary" icon="el-icon-plus" @click="initAddContact">Add Contact</el-button>
                    </div>
                    <br>
                    <el-card class="box-card">
                        <el-table
                          v-loading="loading"
                          :data="contacts"
                          style="width: 100%">
                            <el-table-column
                              width="60">
                                <template slot-scope="scope">
                                    <img :src="contacts[scope.$index].avatar" v-show="contacts[scope.$index].avatar" class="avatar-sm"/>
                                    <svg v-show="!contacts[scope.$index].avatar" width="44" height="44" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M896 0q182 0 348 71t286 191 191 286 71 348q0 181-70.5 347t-190.5 286-286 191.5-349 71.5-349-71-285.5-191.5-190.5-286-71-347.5 71-348 191-286 286-191 348-71zm619 1351q149-205 149-455 0-156-61-298t-164-245-245-164-298-61-298 61-245 164-164 245-61 298q0 250 149 455 66-327 306-327 131 128 313 128t313-128q240 0 306 327zm-235-647q0-159-112.5-271.5t-271.5-112.5-271.5 112.5-112.5 271.5 112.5 271.5 271.5 112.5 271.5-112.5 112.5-271.5z" fill="#909399"/></svg>
                                </template>
                            </el-table-column>
                            <el-table-column
                              prop="first_name"
                              label="First Name">
                            </el-table-column>
                            <el-table-column
                              prop="last_name"
                              label="Last Name">
                            </el-table-column>
                            <el-table-column
                              prop="email"
                              label="Email"
                              width="180">
                            </el-table-column>
                            <el-table-column
                              prop="phone"
                              label="Phone">
                            </el-table-column>
                            <el-table-column
                              prop="address"
                              label="Address">
                            </el-table-column>
                            <el-table-column
                              prop="notes"
                              label="Notes">
                            </el-table-column>
                            <el-table-column
                              align="right"
                              width="180">
                                <template slot-scope="scope">
                                    <el-button @click="initUpdateContact(scope.$index)" type="primary" size="mini" plain>Edit</el-button>
                                    <el-button @click="initDeleteContact(scope.$index)" type="danger" plain size="mini">Delete</el-button>
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-card>
                </el-col>
            </el-row>
        </el-main>

        <el-dialog
          title="Add Contact"
          :visible.sync="dialogAddContact"
          width="30%">
            <el-upload
              class="avatar-uploader"
              action="/upload"
              :headers="{ 'X-CSRF-TOKEN': csrf_token }"
              :show-file-list="false"
              :on-success="handleAvatarSuccess"
              :before-upload="beforeAvatarUpload">
                <img v-if="imageUrl" :src="imageUrl" class="avatar">
                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
            <br>
            <el-form ref="addForm" :model="contact" :rules="rules" status-icon label-width="100px" @keydown.enter.native="createContact">
                <el-form-item label="First name" prop="first_name">
                    <el-input v-model="contact.first_name" ref="addContactFirstName"></el-input>
                </el-form-item>
                <el-form-item label="Last name" prop="last_name">
                    <el-input v-model="contact.last_name"></el-input>
                </el-form-item>
                <el-form-item label="Email">
                    <el-input v-model="contact.email"></el-input>
                </el-form-item>
                <el-form-item label="Phone">
                    <el-input v-model="contact.phone"></el-input>
                </el-form-item>
                <el-form-item label="Address">
                    <el-input v-model="contact.address"></el-input>
                </el-form-item>
                <el-form-item label="Notes">
                    <el-input type="textarea" v-model="contact.notes"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="createContact">Create</el-button>
                    <el-button @click="dialogAddContact = false">Cancel</el-button>
                </el-form-item>
            </el-form>
        </el-dialog> <!-- /dialogAddContact -->

        <el-dialog
          title="Update Contact"
          :visible.sync="dialogUpdateContact"
          width="30%">
            <el-upload
              class="avatar-uploader"
              action="/upload"
              :data="{ id: contactToUpdate.id }"
              :headers="{ 'X-CSRF-TOKEN': csrf_token }"
              :show-file-list="false"
              :on-success="handleAvatarSuccess"
              :before-upload="beforeAvatarUpload">
                <img v-if="imageUrl" :src="imageUrl" class="avatar">
                <i v-else class="el-icon-plus avatar-uploader-icon"></i>
            </el-upload>
            <br>
            <el-form ref="updateForm" :model="contactToUpdate" :rules="rules" status-icon label-width="100px" @keydown.enter.native="updateContact">
                <el-form-item label="First name" prop="first_name">
                    <el-input v-model="contactToUpdate.first_name" ref="updateContactFirstName"></el-input>
                </el-form-item>
                <el-form-item label="Last name" prop="last_name">
                    <el-input v-model="contactToUpdate.last_name"></el-input>
                </el-form-item>
                <el-form-item label="Email">
                    <el-input v-model="contactToUpdate.email"></el-input>
                </el-form-item>
                <el-form-item label="Phone">
                    <el-input v-model="contactToUpdate.phone"></el-input>
                </el-form-item>
                <el-form-item label="Address">
                    <el-input v-model="contactToUpdate.address"></el-input>
                </el-form-item>
                <el-form-item label="Notes">
                    <el-input type="textarea" v-model="contactToUpdate.notes"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="updateContact">Update</el-button>
                    <el-button @click="dialogUpdateContact = false">Cancel</el-button>
                </el-form-item>
            </el-form>
        </el-dialog> <!-- /dialogUpdateContact -->

        <el-dialog
          title="Delete?"
          :visible.sync="dialogDeleteContact"
          width="30%"
          @keydown.enter.native="deleteContact">
            <div class="text-center">
                <img :src="contactToDelete.avatar" v-if="contactToDelete.avatar" class="avatar-md"/>
                <svg v-else width="100" height="100" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M896 0q182 0 348 71t286 191 191 286 71 348q0 181-70.5 347t-190.5 286-286 191.5-349 71.5-349-71-285.5-191.5-190.5-286-71-347.5 71-348 191-286 286-191 348-71zm619 1351q149-205 149-455 0-156-61-298t-164-245-245-164-298-61-298 61-245 164-164 245-61 298q0 250 149 455 66-327 306-327 131 128 313 128t313-128q240 0 306 327zm-235-647q0-159-112.5-271.5t-271.5-112.5-271.5 112.5-112.5 271.5 112.5 271.5 271.5 112.5 271.5-112.5 112.5-271.5z" fill="#909399"/></svg>
            </div>
            <h3 class="text-center">{{ contactToDelete.first_name }} {{ contactToDelete.last_name }}</h3>
            <span slot="footer" class="dialog-footer">
                <el-button plain @click="dialogDeleteContact = false">Cancel</el-button>
                <el-button type="danger" plain @click="deleteContact" autofocus>Delete</el-button>
            </span>
        </el-dialog> <!-- /dialogDeleteContact -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                contact: {
                    first_name: '',
                    last_name: '',
                    address: '',
                    avatar: '',
                    email: '',
                    notes: '',
                    phone: '',
                },
                contacts: [],
                contactToUpdate: {},
                contactToDelete: {},
                csrf_token: window.axios.defaults.headers.common['X-CSRF-TOKEN'],
                dialogAddContact: false,
                dialogDeleteContact: false,
                dialogUpdateContact: false,
                formData: {},
                imageUrl: '',
                loading: true,
                rules: {
                    first_name: [
                        { required: true, message: 'Please input First Name', trigger: 'blur' },
                        { min: 2, max: 100, message: 'Length should be 2 to 100', trigger: 'blur' }
                    ],
                    last_name: [
                        { required: true, message: 'Please input Last name', trigger: 'blur' },
                        { min: 2, max: 100, message: 'Length should be 2 to 100', trigger: 'blur' }
                    ]
                }
            }
        },

        mounted() {
            this.fetchData();
            this.formData = new FormData();
        },

        methods: {
            createContact() {
                this.$refs['addForm'].validate((valid) => {
                    if (valid) {
                        let contact = JSON.stringify(this.contact);
                        this.formData.append('contact', contact);

                        axios.post('/contacts', this.formData)
                        .then(response => {
                            this.contacts.push(response.data.contact);
                            this.dialogAddContact = false;
                            this.$message.success('Contact have been created successfully!');

                            this.$refs['addForm'].resetFields();
                            this.resetContact();
                        })
                        .catch(error => {
                            this.$message.error('Oops! Something went wrong.');
                            console.log(error);
                        });
                    } else {
                        this.$message.error('Oops, please fill required fields.');
                        return false;
                    }
                });
            },

            deleteContact() {
                let that = this;
                axios.delete('/contacts/' + this.contactToDelete.id)
                    .then(response => {
                        this.contacts = this.contacts.filter(function (item) {
                            return item.id != that.contactToDelete.id;
                        });
                        this.$message.success('Contact have been deleted successfully!');
                        this.dialogDeleteContact = false;
                    })
                    .catch(error => {
                        this.$message.error('Oops! Something went wrong.');
                        console.log(error);
                    });
            },

            fetchData() {
                axios.get('/contacts')
                    .then(response => {
                        this.contacts = response.data.contacts;
                        this.loading = false;
                    });
            },

            initAddContact() {
                this.dialogAddContact = true;
                this.resetContact();

                let that = this;
                setTimeout(function() {
                    that.$refs.addContactFirstName.focus();
                }, 0)
            },

            initDeleteContact(index) {
                this.dialogDeleteContact = true;
                this.contactToDelete = this.contacts[index];
            },

            initUpdateContact(index) {
                this.dialogUpdateContact = true;
                this.contactToUpdate = this.contacts[index];
                this.imageUrl = this.contactToUpdate.avatar;

                let that = this;
                setTimeout(function() {
                    that.$refs.updateContactFirstName.focus();
                }, 0)
            },

            resetContact() {
                this.contact.first_name = '';
                this.contact.last_name = '';
                this.contact.address = '';
                this.contact.avatar = '';
                this.contact.email = '';
                this.contact.notes = '';
                this.contact.phone = '';
                this.formData.delete('contact');
                this.formData.delete('file');
                this.formData.delete('_method');
                this.imageUrl = '';
            },

            updateContact() {
                this.$refs['updateForm'].validate((valid) => {
                    if (valid) {
                        let contact = JSON.stringify(this.contactToUpdate);
                        this.formData.append('contact', contact);
                        this.formData.append('_method', 'PATCH');

                        axios.post('/contacts/' + this.contactToUpdate.id, this.formData)
                        .then(response => {
                            this.dialogUpdateContact = false;
                            this.$message.success('Contact have been updated successfully!');
                            this.contactToUpdate.avatar = this.imageUrl;
                        })
                        .catch(error => {
                            this.$message.error('Oops! Something went wrong.');
                            console.log(error);
                        });
                    } else {
                        this.$message.error('Oops, please fill required fields.');
                        return false;
                    }
                });
            },

            // Image upload
            handleAvatarSuccess(res, file) {
                this.formData.append('file', file.raw, file.raw.name);
                this.imageUrl = URL.createObjectURL(file.raw);
            },

            beforeAvatarUpload(file) {
                const isJPG = file.type === 'image/jpeg';
                const isPNG = file.type === 'image/png';
                const isLt2M = file.size / 1024 / 1024 < 2;

                if (!isJPG && !isPNG) {
                    this.$message.error('Avatar picture must be JPG or PNG format!');
                }
                if (!isLt2M) {
                    this.$message.error('Avatar picture size can not exceed 2MB!');
                }
                return isJPG && isLt2M || isPNG && isLt2M;
            }
        }
    }
</script>

<style>
    .avatar-uploader {
        text-align: center;
    }

    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        border-radius: 50%;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }

    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }

    .avatar {
        width: 178px;
        height: 178px;
        display: block;
    }

    .avatar-sm {
        width: 46px;
        height: 46px;
        border-radius: 50%;
    }

    .avatar-md {
        width: 100px;
        height: 100px;
        border-radius: 50%;
    }

    .el-dropdown {
        position: relative;
        float: right;
    }

    .el-dropdown-link {
        margin-top: 15px;
        display: inline-block;
    }

    .el-dropdown-link:hover .user-name {
        color: #e5e9f2;
    }

    .el-dropdown-link:hover path {
        fill: #e5e9f2;
    }

    .el-dropdown svg {
        vertical-align: middle;
        margin: 0 10px;
    }

    .el-table td {
        padding: 6px 0;
    }

    .el-table .cell {
        line-height: 14px;
    }
</style>

