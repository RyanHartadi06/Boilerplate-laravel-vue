<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import Checkbox from "@/Components/Template/Checkbox.vue";
import InputError from "@/Components/Template/InputError.vue";
import InputLabel from "@/Components/Template/InputLabel.vue";
import TextInput from "@/Components/Template/TextInput.vue";
import Alert from "@/Components/Global/Notification/Alert.vue";

defineProps({
    canResetPassword: Boolean,
});

const form = useForm({
    username: null,
    password: null,
    remember: false,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login.attempt"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<script>
export default {
    data() {
        return {
            togglePassword: false,
        };
    },
};
</script>

<template>
    <Head title="Log in" />

    <div class="auth-page-wrapper pt-5">
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    version="1.1"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120"
                >
                    <path
                        d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"
                    ></path>
                </svg>
            </div>
        </div>

        <div class="auth-page-content">
            <BContainer>
                <BRow>
                    <BCol lg="12">
                        <div class="text-center mb-4 text-white-50">
                            <div>
                                <Link href="/" class="d-inline-block auth-logo">
                                    <img
                                        src="/images/logo.png"
                                        alt=""
                                        height="80"
                                    />
                                </Link>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">
                                HCMS - PT Surabaya Industrial Estate Rungkut
                            </p>
                        </div>
                    </BCol>
                </BRow>

                <BRow class="justify-content-center">
                    <BCol md="8" lg="6" xl="5">
                        <BCard no-body class="mt-4">
                            <BCardBody class="p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">
                                        Sign in to continue to HCMS.
                                    </p>
                                </div>
                                <div class="p-2 mt-3">
                                    <form @submit.prevent="submit">
                                        <div class="mb-3">
                                            <InputLabel
                                                for="username"
                                                value="Username"
                                            />
                                            <TextInput
                                                id="username"
                                                v-model="form.username"
                                                type="text"
                                                class="form-control"
                                                autofocus
                                                placeholder="Please enter username"
                                                autocomplete="username"
                                                required
                                                :class="{
                                                    'is-invalid':
                                                        form.errors.username,
                                                }"
                                            />
                                            <InputError
                                                :message="form.errors.username"
                                            />
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <Link
                                                    v-if="canResetPassword"
                                                    :href="
                                                        route(
                                                            'password.request'
                                                        )
                                                    "
                                                    class="text-muted"
                                                    >Forgot password?</Link
                                                >
                                            </div>
                                            <InputLabel
                                                for="password"
                                                value="Password"
                                            />
                                            <div
                                                class="position-relative auth-pass-inputgroup mb-3"
                                            >
                                                <input
                                                    :type="
                                                        togglePassword
                                                            ? 'text'
                                                            : 'password'
                                                    "
                                                    class="form-control pe-5"
                                                    placeholder="Enter password"
                                                    id="password-input"
                                                    v-model="form.password"
                                                    autocomplete="password"
                                                    required
                                                    :class="{
                                                        'is-invalid':
                                                            form.errors
                                                                .password,
                                                    }"
                                                />
                                                <BButton
                                                    variant="link"
                                                    class="position-absolute end-0 top-0 text-decoration-none text-muted"
                                                    type="button"
                                                    id="password-addon"
                                                    @click="
                                                        togglePassword =
                                                            !togglePassword
                                                    "
                                                >
                                                    <i
                                                        class="ri-eye-fill align-middle"
                                                    ></i>
                                                </BButton>
                                                <InputError
                                                    :message="
                                                        form.errors.password
                                                    "
                                                />
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <Checkbox
                                                v-model:checked="form.remember"
                                                name="remember"
                                                class="form-check-input"
                                                id="auth-remember-check"
                                            />
                                            <label
                                                class="form-check-label"
                                                for="auth-remember-check"
                                                >Remember me</label
                                            >
                                        </div>

                                        <div class="mt-4">
                                            <BButton
                                                variant="secondary"
                                                class="w-100"
                                                type="submit"
                                                :class="{
                                                    'opacity-25':
                                                        form.processing,
                                                }"
                                                :disabled="form.processing"
                                                >Sign In</BButton
                                            >
                                        </div>
                                    </form>
                                </div>
                            </BCardBody>
                        </BCard>
                    </BCol>
                </BRow>
            </BContainer>
        </div>

        <footer class="footer">
            <BContainer>
                <BRow>
                    <BCol lg="12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">
                                &copy; {{ new Date().getFullYear() }} HCMS.
                                <i class="mdi mdi-heart text-danger"></i> PT
                                Surabaya Industrial Estate Rungkut
                            </p>
                        </div>
                    </BCol>
                </BRow>
            </BContainer>
        </footer>

        <Alert />
    </div>
</template>
