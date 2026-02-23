<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Minus, Plus, ShoppingCart } from 'lucide-vue-next';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { order } from '@/routes';

withDefaults(
    defineProps<{
        products: any;
    }>(),
    {
        products: [],
    },
);

const cart = ref<number[]>([]);

const addToCart = (productId: number) => {
    cart.value.push(productId);
    console.log(cart.value);
};

const removeFromCart = (productId: number) => {
    cart.value.splice(cart.value.indexOf(productId), 1);
    console.log(cart.value);
};

</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div
        class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]"
    >
        <header
            class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl"
        >
            <nav class="flex items-center justify-end gap-4">
                <Link :href='order()' class="flex gap-2 items-center">
                    <ShoppingCart class="w-4 h-4" />{{ cart.length }}
                </Link>
            </nav>
        </header>
        <div
            class="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0"
        >
            <main
                class="flex w-full max-w-[335px] flex-col-reverse overflow-hidden rounded-lg lg:max-w-4xl lg:flex-row"
            >
                <div class="w-full flex justify-between items-center flex-wrap">
                    <div v-for="product in products" :key="product.id" class="w-[48%] mb-4">
                        <Card class="h-108">
                            <CardHeader>
                                <img :src="`/storage/${product.image}`" :alt="product.name" class="w-full h-48 object-contain" />
                                <CardTitle>{{ product.name }}</CardTitle>
                                <CardDescription class="line-clamp-2">{{ product.description }}</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <p>$ {{ product.price }}</p>
                            </CardContent>
                            <CardFooter>
                                <div v-if="cart.includes(product.id)" class="flex justify-between items-center gap-4">
                                    <Button variant="outline" @click="removeFromCart(product.id)">
                                        <Minus />
                                    </Button>
                                    <p>{{ cart.filter((id) => id === product.id).length }}</p>
                                    <Button variant="outline" @click="addToCart(product.id)">
                                        <Plus />
                                    </Button>
                                </div>
                                <div v-else>
                                    <Button @click="addToCart(product.id)">Add to Cart</Button>
                                </div>
                            </CardFooter>
                        </Card>
                    </div>
                </div>
            </main>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
