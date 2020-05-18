export interface Dessert {
    calories: number;
    carbs: number;
    fat: number;
    name: string;
    protein: number;
}
export interface Item {
    id: number,
    name: string,
    price: number,
    color?: string,
    id_brand: number,
    id_model: number,
    created_at: Date,
    updated_at: Date
    deleted_at?: Date

}