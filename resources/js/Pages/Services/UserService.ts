import axios, {AxiosResponse} from 'axios';
import {ref, Ref} from 'vue';
import {router} from '@inertiajs/vue3';

interface User {
    // Define the user properties based on the expected response
    id: number;
    name: string;
    email: string;
    // Add other relevant properties
}

class UserService {
    user: Ref<User | null>;
    apiUrl: string;
    headers: Record<string, string>;

    constructor() {
        this.user = ref<User | null>(null);
        this.apiUrl = '/api';
        this.headers = {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('access_token')}`,
            'Cache-Control': 'no-cache'
        };
    }

    async fetchUser(): Promise<void> {
        try {
            const response: AxiosResponse<{ data: User }> = await axios.get(`${this.apiUrl}/user`, {
                headers: this.headers
            });

            if (response.status !== 200) {
                router.visit('/login');
                return;
            }

            const data = response.data;
            localStorage.setItem('user', JSON.stringify(data.data));
            this.user.value = data.data;

        } catch (error) {
            console.error('Error fetching user:', error);
            router.visit('/login');
        }
    }

    async updateUser(userId: number, userData: Partial<User>) {
        const response = await axios.put(`${this.apiUrl}/user/${userId}`, userData, {headers: this.headers});
        return response.data;
    }

    async updateUserRole(userId: number, roleId: number) {
        const response = await axios.put(`${this.apiUrl}/user/${userId}/role/${roleId}`, {}, {headers: this.headers});
        return response.data;
    }

    async fetchRoles() {
        const response = await axios.get(`${this.apiUrl}/role`, {headers: this.headers});
        return response.data;
    }
    async createUser(userData) {
        const response = await axios.post(`${this.apiUrl}/user`, userData, { headers: this.headers });
        return response.data;
    }
    async deleteUser(userId) {
        const response = await axios.delete(`${this.apiUrl}/user/${userId}`, { headers: this.headers });
        return response;
    }
    async fetchUserList() {
        const response = await axios.get(`${this.apiUrl}/user/list`, { headers: this.headers });
        return response.data;
    }
}

export default new UserService();
