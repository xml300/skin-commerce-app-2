<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // Keep for potential future use
use Illuminate\Support\Str; // Used for basic address parsing fallback

// Import your models (adjust paths if necessary - assumes App\Models namespace)
use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Review;
use App\Models\Ingredient;
use App\Models\SkinConcern;
use App\Models\SkinType;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use App\Models\OrderItem;
use App\Models\ShippingAddress;
// Note: Pivot models like ProductIngredient are usually not needed directly for seeding when using attach()

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Prepare Data from Original JSON (Embedded Here) ---
        $originalProducts = json_decode(<<<'JSON'
        [
            {"product_id": 1, "product_name": "Hydrating Hyaluronic Acid Serum", "description": "This lightweight serum deeply hydrates the skin, plumping fine lines and wrinkles for a smoother, more youthful complexion. Hyaluronic acid attracts and holds moisture, providing long-lasting hydration. Benefits include improved skin elasticity, reduced dryness, and a radiant glow. To use, apply a few drops to damp skin after cleansing and before moisturizing, morning and night.", "ingredients": ["Water", "Hyaluronic Acid", "Glycerin", "Propanediol", "Sodium Hyaluronate", "Panthenol (Vitamin B5)", "Ceramides", "Phenoxyethanol", "Ethylhexylglycerin"], "skin_types": ["dry", "combination", "sensitive", "normal"], "skin_concerns": ["dryness", "fine lines", "dehydration", "aging"], "brand_id": 1, "category_id": 6, "price": 4200, "stock_quantity": 150, "product_images": [{}], "product_videos": [], "rating_average": 4.7, "review_count": 75, "created_at": "2024-01-15T10:30:00Z", "updated_at": "2024-02-20T14:45:00Z"},
            {"product_id": 2, "product_name": "Gentle Foaming Facial Cleanser", "description": "A mild and effective cleanser that removes dirt, oil, and impurities without stripping the skin's natural moisture barrier. Formulated with soothing botanicals, it leaves skin feeling clean, soft, and refreshed. Ideal for daily use, morning and night. For best results, lather a small amount with water and massage onto face, then rinse thoroughly.", "ingredients": ["Water", "Coco-Glucoside", "Glycerin", "Aloe Barbadensis Leaf Juice", "Chamomile Extract", "Green Tea Extract", "Citric Acid", "Sodium Benzoate", "Potassium Sorbate"], "skin_types": ["all", "sensitive", "normal", "combination"], "skin_concerns": ["cleansing", "redness", "irritation", "daily care"], "brand_id": 2, "category_id": 2, "price": 29250, "stock_quantity": 200, "product_images": ["https://example.com/images/gentle_cleanser_1.jpg"], "product_videos": [], "rating_average": 4.5, "review_count": 120, "created_at": "2024-02-01T09:00:00Z", "updated_at": "2024-02-15T11:20:00Z"},
            {"product_id": 3, "product_name": "Vitamin C Brightening Moisturizer", "description": "A daily moisturizer infused with Vitamin C to brighten skin tone, reduce dark spots, and protect against environmental damage. This cream provides essential hydration while promoting collagen production for firmer, more radiant skin. Apply liberally to face and neck in the morning after serum. Continued use improves skin clarity and texture.", "ingredients": ["Water", "Vitamin C (Ascorbic Acid)", "Shea Butter", "Jojoba Oil", "Niacinamide (Vitamin B3)", "Tocopherol (Vitamin E)", "Ferulic Acid", "Citrus Aurantium Dulcis (Orange) Peel Oil", "Phenoxyethanol"], "skin_types": ["all", "normal", "combination", "oily"], "skin_concerns": ["dullness", "dark spots", "uneven skin tone", "antioxidant"], "brand_id": 3, "category_id": 3, "price": 52500, "stock_quantity": 100, "product_images": ["https://example.com/images/vitamin_c_moisturizer_1.jpg", "https://example.com/images/vitamin_c_moisturizer_2.jpg", "https://example.com/images/vitamin_c_moisturizer_3.jpg"], "product_videos": [], "rating_average": 4.8, "review_count": 95, "created_at": "2023-12-20T14:00:00Z", "updated_at": "2024-01-25T16:30:00Z"},
            {"product_id": 4, "product_name": "Acne Treatment Salicylic Acid Toner", "description": "A targeted toner formulated with salicylic acid to exfoliate pores, reduce blemishes, and prevent future breakouts. This toner helps to control oil production and clarify the skin. Use 1-2 times daily after cleansing, applying with a cotton pad to affected areas. Start slowly to assess skin tolerance.", "ingredients": ["Water", "Salicylic Acid", "Witch Hazel Extract", "Tea Tree Oil", "Glycolic Acid", "Lactic Acid", "Sodium Hydroxide", "Phenoxyethanol"], "skin_types": ["oily", "acne-prone", "combination"], "skin_concerns": ["acne", "blackheads", "large pores", "oil control"], "brand_id": 1, "category_id": 4, "price": 33000, "stock_quantity": 180, "product_images": ["https://example.com/images/salicylic_acid_toner_1.jpg"], "product_videos": [], "rating_average": 4.3, "review_count": 60, "created_at": "2024-02-10T16:00:00Z", "updated_at": "2024-02-28T09:15:00Z"},
            {"product_id": 5, "product_name": "Soothing Night Cream for Sensitive Skin", "description": "A rich and calming night cream designed to nourish and repair sensitive skin overnight. Enriched with ceramides and calming extracts, it reduces redness and irritation while strengthening the skin barrier. Apply a generous layer to face and neck as the last step in your nighttime skincare routine. Wake up to soothed, hydrated, and balanced skin.", "ingredients": ["Water", "Glycerin", "Squalane", "Ceramides NP", "Calendula Officinalis Flower Extract", "Oat Kernel Extract", "Bisabolol", "Allantoin", "Butyrospermum Parkii (Shea Butter)", "Cetearyl Alcohol", "Phenoxyethanol"], "skin_types": ["sensitive", "dry", "normal"], "skin_concerns": ["sensitive skin", "redness", "irritation", "nighttime repair"], "brand_id": 4, "category_id": 3, "price": 57000, "stock_quantity": 120, "product_images": ["https://example.com/images/night_cream_sensitive_1.jpg", "https://example.com/images/night_cream_sensitive_2.jpg"], "product_videos": [], "rating_average": 4.6, "review_count": 88, "created_at": "2024-01-28T11:45:00Z", "updated_at": "2024-02-22T13:00:00Z"},
            {"product_id": 6, "product_name": "Mineral Sunscreen SPF 30", "description": "A broad-spectrum mineral sunscreen that provides SPF 30 protection using zinc oxide and titanium dioxide. Gentle and reef-safe, it's suitable for all skin types, including sensitive. Protects skin from UVA and UVB rays, preventing sunburn and premature aging. Apply liberally 15 minutes before sun exposure and reapply every two hours, or immediately after swimming or sweating.", "ingredients": ["Zinc Oxide", "Titanium Dioxide", "Water", "Caprylic/Capric Triglyceride", "Glycerin", "Aloe Barbadensis Leaf Juice", "Green Tea Extract", "Tocopherol (Vitamin E)", "Iron Oxides"], "skin_types": ["all", "sensitive", "normal", "combination", "oily"], "skin_concerns": ["sun protection", "sensitive skin", "daily protection", "environmental protection"], "brand_id": 2, "category_id": 5, "price": 37500, "stock_quantity": 250, "product_images": ["https://example.com/images/mineral_sunscreen_1.jpg"], "product_videos": ["https://example.com/videos/mineral_sunscreen_video.mp4"], "rating_average": 4.9, "review_count": 150, "created_at": "2023-11-15T08:00:00Z", "updated_at": "2024-01-10T12:00:00Z"},
            {"product_id": 7, "product_name": "Retinol Anti-Aging Serum", "description": "A potent retinol serum to target signs of aging, including wrinkles, fine lines, and uneven texture. Retinol promotes skin cell turnover and collagen production for smoother, firmer skin. Start with nighttime use 2-3 times per week and gradually increase frequency as tolerated. Apply a pea-sized amount to dry skin after cleansing, followed by moisturizer. Use sunscreen daily when using retinol products.", "ingredients": ["Water", "Retinol", "Squalane", "Jojoba Oil", "Hyaluronic Acid", "Vitamin E (Tocopherol)", "Green Tea Extract", "Phenoxyethanol"], "skin_types": ["normal", "combination", "oily", "mature"], "skin_concerns": ["aging", "wrinkles", "fine lines", "texture", "uneven tone"], "brand_id": 3, "category_id": 6, "price": 67500, "stock_quantity": 80, "product_images": ["https://example.com/images/retinol_serum_1.jpg", "https://example.com/images/retinol_serum_2.jpg"], "product_videos": [], "rating_average": 4.6, "review_count": 65, "created_at": "2024-03-01T15:30:00Z", "updated_at": "2024-03-05T10:00:00Z"}
        ]
JSON
        , true); // true for associative array

        $originalUsers = json_decode(<<<'JSON'
        [
            {"user_id": 1, "username": "skincare_lover", "email": "skincare_lover@email.com", "password_hash": "$2y$10$abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrs", "first_name": "Aisha", "last_name": "Adekunle", "billing_address": "12, Tinubu Street, Lagos Island, Lagos", "shipping_addresses": ["12, Tinubu Street, Lagos Island, Lagos", "Plot 45, Isaac John Street, Ikeja, Lagos"], "phone_number": "+2348012345678", "created_at": "2023-10-15T14:30:00Z", "updated_at": "2024-01-05T09:00:00Z"},
            {"user_id": 2, "username": "beauty_guru_ng", "email": "beauty_guru_ng@email.com", "password_hash": "$2y$10$zyxwvutsrqponmlkjihgfedcba9876543210zyxwvutsrqponmlkjihg", "first_name": "Chukwudi", "last_name": "Okonkwo", "billing_address": "5, Park Avenue, Enugu, Enugu State", "shipping_addresses": ["5, Park Avenue, Enugu, Enugu State"], "phone_number": "+2349098765432", "created_at": "2023-11-20T10:00:00Z", "updated_at": "2024-02-10T16:45:00Z"},
            {"user_id": 3, "username": "makeup_maven", "email": "makeup_maven@email.com", "password_hash": "$2y$10$mnopqrstuvwxyzabcdefghijkl0123456789mnopqrstuvwxyzabcdefgh", "first_name": "Halima", "last_name": "Bello", "billing_address": "22, Sultan Road, Kaduna, Kaduna State", "shipping_addresses": ["22, Sultan Road, Kaduna, Kaduna State", "3, Ahmadu Bello Way, Abuja"], "phone_number": "+2347055554444", "created_at": "2023-12-01T18:00:00Z", "updated_at": "2024-02-28T12:00:00Z"},
            {"user_id": 4, "username": "natural_beauty", "email": "natural_beauty@email.com", "password_hash": "$2y$10$cdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwx", "first_name": "Ifeoma", "last_name": "Okafor", "billing_address": "7, Uselu-Lagos Road, Benin City, Edo State", "shipping_addresses": ["7, Uselu-Lagos Road, Benin City, Edo State"], "phone_number": "+2348166667777", "created_at": "2024-01-15T08:30:00Z", "updated_at": "2024-03-05T15:30:00Z"}
        ]
JSON
        , true);

        $originalBrands = json_decode(<<<'JSON'
        [
              {"brand_id": 1, "brand_name": "GlowRite", "brand_logo": "https://example.com/logos/glowrite.png", "brand_description": "GlowRite focuses on effective and affordable skincare solutions for all skin types."},
              {"brand_id": 2, "brand_name": "Botanical Bliss", "brand_logo": "https://example.com/logos/botanicalbliss.png", "brand_description": "Botanical Bliss uses natural and organic ingredients to create gentle yet powerful skincare."},
              {"brand_id": 3, "brand_name": "Dermaclear", "brand_logo": "https://example.com/logos/dermaclear.png", "brand_description": "Dermaclear is dedicated to advanced dermatological skincare, addressing specific skin concerns with science-backed formulas."},
              {"brand_id": 4, "brand_name": "Aura Beauty", "brand_logo": "https://example.com/logos/aurabeauty.png", "brand_description": "Aura Beauty emphasizes luxurious and sensorial skincare experiences, combining efficacy with indulgence."}
        ]
JSON
        , true);

        $originalCategories = json_decode(<<<'JSON'
        [
              {"category_id": 1, "category_name": "Skincare", "parent_category_id": null, "category_image": "https://example.com/images/skincare_category.jpg"},
              {"category_id": 2, "category_name": "Cleansers", "parent_category_id": 1, "category_image": "https://example.com/images/cleansers_category.jpg"},
              {"category_id": 3, "category_name": "Moisturizers", "parent_category_id": 1, "category_image": "https://example.com/images/moisturizers_category.jpg"},
              {"category_id": 4, "category_name": "Toners", "parent_category_id": 1, "category_image": "https://example.com/images/toners_category.jpg"},
              {"category_id": 5, "category_name": "Sunscreen", "parent_category_id": 1, "category_image": "https://example.com/images/sunscreen_category.jpg"},
              {"category_id": 6, "category_name": "Serums", "parent_category_id": 1, "category_image": "https://example.com/images/serums_category.jpg"},
              {"category_id": 7, "category_name": "Makeup", "parent_category_id": null, "category_image": "https://example.com/images/makeup_category.jpg"},
              {"category_id": 8, "category_name": "Foundations", "parent_category_id": 7, "category_image": "https://example.com/images/foundations_category.jpg"}
        ]
JSON
        , true);

        $originalOrders = json_decode(<<<'JSON'
        [
            {"order_id": 101, "user_id": 1, "order_date": "2024-02-22T15:00:00Z", "order_status": "Shipped", "shipping_address": "Plot 45, Isaac John Street, Ikeja, Lagos", "billing_address": "12, Tinubu Street, Lagos Island, Lagos", "payment_method": "Card", "total_amount": 99750.00, "shipping_cost": 5000.00, "discount_applied": 0.00, "order_items": "[{\"product_id\": 1, \"quantity\": 2}, {\"product_id\": 3, \"quantity\": 1}]", "tracking_number": "TRACK123456789", "created_at": "2024-02-22T14:55:00Z", "updated_at": "2024-02-23T10:00:00Z"},
            {"order_id": 102, "user_id": 2, "order_date": "2024-03-01T11:30:00Z", "order_status": "Processing", "shipping_address": "5, Park Avenue, Enugu, Enugu State", "billing_address": "5, Park Avenue, Enugu, Enugu State", "payment_method": "Bank Transfer", "total_amount": 62250.00, "shipping_cost": 3000.00, "discount_applied": 5000.00, "order_items": "[{\"product_id\": 2, \"quantity\": 1}, {\"product_id\": 4, \"quantity\": 1}]", "tracking_number": null, "created_at": "2024-03-01T11:20:00Z", "updated_at": "2024-03-01T12:00:00Z"},
            {"order_id": 103, "user_id": 3, "order_date": "2024-03-05T16:45:00Z", "order_status": "Delivered", "shipping_address": "3, Ahmadu Bello Way, Abuja", "billing_address": "22, Sultan Road, Kaduna, Kaduna State", "payment_method": "Card", "total_amount": 105000.00, "shipping_cost": 7500.00, "discount_applied": 0.00, "order_items": "[{\"product_id\": 3, \"quantity\": 2}]", "tracking_number": "TRACK987654321", "created_at": "2024-03-05T16:30:00Z", "updated_at": "2024-03-06T08:00:00Z"},
            {"order_id": 104, "user_id": 4, "order_date": "2024-03-08T09:00:00Z", "order_status": "Pending", "shipping_address": "7, Uselu-Lagos Road, Benin City, Edo State", "billing_address": "7, Uselu-Lagos Road, Benin City, Edo State", "payment_method": "Pay on Delivery", "total_amount": 37500.00, "shipping_cost": 4000.00, "discount_applied": 0.00, "order_items": "[{\"product_id\": 6, \"quantity\": 1}]", "tracking_number": null, "created_at": "2024-03-08T08:50:00Z", "updated_at": "2024-03-08T09:15:00Z"}
        ]
JSON
        , true);

        $originalReviews = json_decode(<<<'JSON'
        [
            {"review_id": 1, "user_id": 1, "product_id": 1, "rating": 5, "review_text": "This serum is amazing! My skin feels so hydrated and plump. Definitely worth the price.", "review_date": "2024-02-25T10:00:00Z", "is_approved": true},
            {"review_id": 2, "user_id": 2, "product_id": 2, "rating": 4, "review_text": "A very gentle cleanser, perfect for my sensitive skin. It cleans well without drying out my face.", "review_date": "2024-03-02T14:30:00Z", "is_approved": true},
            {"review_id": 3, "user_id": 3, "product_id": 3, "rating": 5, "review_text": "I've noticed a visible difference in my skin's brightness after using this moisturizer for a few weeks. Love it!", "review_date": "2024-03-06T18:00:00Z", "is_approved": true},
            {"review_id": 4, "user_id": 4, "product_id": 4, "rating": 3, "review_text": "It's an okay toner. It does help with breakouts but can be a bit drying if used too often.", "review_date": "2024-03-09T09:15:00Z", "is_approved": false},
            {"review_id": 5, "user_id": 1, "product_id": 5, "rating": 4, "review_text": "This night cream is very soothing and rich. Great for nighttime routine, especially during harmattan.", "review_date": "2024-03-10T12:00:00Z", "is_approved": true},
            {"review_id": 6, "user_id": 2, "product_id": 6, "rating": 5, "review_text": "Best sunscreen ever! It's mineral, reef-safe and doesn't leave a white cast on my skin. Perfect for Lagos sun.", "review_date": "2024-03-11T16:00:00Z", "is_approved": true},
            {"review_id": 7, "user_id": 3, "product_id": 7, "rating": 4, "review_text": "Good retinol serum, starting to see some improvements in my skin texture. Remember to use sunscreen!", "review_date": "2024-03-12T10:30:00Z", "is_approved": true}
        ]
JSON
        , true);
        // --- End Data Preparation ---


        // Optional: Disable foreign key checks
        // DB::statement('SET CONSTRAINTS ALL DEFERRED;'); // PostgreSQL syntax
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // MySQL syntax
        $this->command->warn('Attempting to disable foreign key checks (syntax may vary by DB)...');
        try {
            match (DB::connection()->getDriverName()) {
                'mysql' => DB::statement('SET FOREIGN_KEY_CHECKS=0;'),
                'pgsql' => DB::statement('SET CONSTRAINTS ALL DEFERRED;'),
                 // Add other drivers if needed
                 default => $this->command->warn('Unsupported DB driver for disabling FK checks automatically.'),
            };
             $this->command->info('Foreign key checks likely disabled.');
        } catch (\Exception $e) {
            $this->command->error('Could not disable foreign key checks: ' . $e->getMessage());
        }


        // Truncate tables in an order that respects dependencies (or disable FK checks)
        $this->command->info('Truncating tables...');
        OrderItem::truncate();
        Review::truncate();
        // Pivot tables for products
        DB::table('product_ingredients')->truncate();
        DB::table('product_skin_concerns')->truncate();
        DB::table('product_skin_types')->truncate();
        ProductImage::truncate();
        ProductVideo::truncate();
        // Core tables
        Order::truncate();
        Product::truncate();
        Category::truncate();
        Brand::truncate();
        ShippingAddress::truncate(); // Clear shipping addresses before users
        User::truncate();
        // Lookup tables
        Ingredient::truncate();
        SkinConcern::truncate();
        SkinType::truncate();
        $this->command->info('Tables truncated successfully.');

        // --- Seed Lookup Tables (Ingredients, Skin Concerns, Skin Types) ---
        $ingredientMap = [];
        $skinConcernMap = [];
        $skinTypeMap = [];

        $allIngredients = collect($originalProducts)->pluck('ingredients')->flatten()->unique()->filter();
        $allSkinConcerns = collect($originalProducts)->pluck('skin_concerns')->flatten()->unique()->filter();
        $allSkinTypes = collect($originalProducts)->pluck('skin_types')->flatten()->unique()->filter();

        foreach ($allIngredients as $name) {
            $ingredient = Ingredient::firstOrCreate(['ingredient_name' => trim($name)]);
            $ingredientMap[trim($name)] = $ingredient->id;
        }
        $this->command->info('Ingredients table seeded (' . count($ingredientMap) . ' records).');

        foreach ($allSkinConcerns as $name) {
            $concern = SkinConcern::firstOrCreate(['skin_concern_name' => trim($name)]);
            $skinConcernMap[trim($name)] = $concern->id;
        }
        $this->command->info('SkinConcerns table seeded (' . count($skinConcernMap) . ' records).');

        foreach ($allSkinTypes as $name) {
            $type = SkinType::firstOrCreate(['skin_type_name' => trim($name)]);
            $skinTypeMap[trim($name)] = $type->id;
        }
        $this->command->info('SkinTypes table seeded (' . count($skinTypeMap) . ' records).');


        // --- Seed Brands ---
        foreach ($originalBrands as $brandData) {
             $id = $brandData['brand_id'];
             unset($brandData['brand_id']);
             // Ensure unique brand_name before creating
             $brandName = $brandData['brand_name'];
             unset($brandData['brand_name']);
             Brand::updateOrCreate(
                ['brand_name' => $brandName], // Find by unique name
                array_merge(['id' => $id], $brandData) // Update/Create with ID and other data
             );
        }
        $this->command->info('Brands table seeded!');


        // --- Seed Categories ---
         foreach ($originalCategories as $categoryData) {
             $id = $categoryData['category_id'];
             unset($categoryData['category_id']);
             // Ensure unique category_name before creating
             $categoryName = $categoryData['category_name'];
             unset($categoryData['category_name']);
             Category::updateOrCreate(
                ['category_name' => $categoryName], // Find by unique name
                array_merge(['id' => $id], $categoryData) // Update/Create with ID and other data
             );
        }
        $this->command->info('Categories table seeded!');


        // --- Seed Users and Shipping Addresses ---
        foreach ($originalUsers as $userData) {
            $userId = $userData['user_id'];
            $billingAddressString = $userData['billing_address'];
            $shippingAddressArray = $userData['shipping_addresses'] ?? []; // Ensure it's an array

            $originalBilling = $userData['billing_address']; // Keep original string for orders table
            unset($userData['user_id']);
            unset($userData['billing_address']);
            unset($userData['shipping_addresses']);

            // Rename password_hash to password
            if (isset($userData['password_hash'])) {
                $userData['password'] = $userData['password_hash'];
                unset($userData['password_hash']);
            }
            $userData['user_type'] = $userData['user_type'] ?? 0; // Add default user_type (e.g., 0 for regular user)

            // Use updateOrCreate with unique email/username to handle reruns robustly
            $uniqueIdentifier = ['email' => $userData['email']]; // Or ['username' => $userData['username']]
            $user = User::updateOrCreate(
                $uniqueIdentifier,
                array_merge(['id' => $userId], $userData) // Ensure the correct ID is set
            );

            // Reassign the ID in case updateOrCreate found an existing user with a different ID (shouldn't happen if truncated)
            if ($user->id != $userId) {
                 $this->command->warn("User ID mismatch for email {$userData['email']}. Forcing ID {$userId}.");
                 DB::table('users')->where('id', $user->id)->update(['id' => $userId]);
                 $user = User::find($userId); // Re-fetch the user model with the correct ID
            }


            // Seed Shipping Addresses (Basic Parsing - Improve if needed)
            $addressesToSeed = [];
            if($billingAddressString) $addressesToSeed[] = $billingAddressString;
            if(is_array($shippingAddressArray)) $addressesToSeed = array_merge($addressesToSeed, $shippingAddressArray);
            $addressesToSeed = array_unique(array_filter($addressesToSeed)); // Remove empties and duplicates

            foreach($addressesToSeed as $addressString) {
                if (empty(trim($addressString))) continue;

                // Basic parsing - adjust logic as needed! Robust parsing is complex.
                $parts = array_map('trim', explode(',', trim($addressString)));
                $street = $parts[0] ?? 'N/A';
                $city = $parts[1] ?? 'Unknown City';
                $state = $parts[2] ?? 'Unknown State';
                $country = count($parts) > 3 ? $parts[3] : 'Nigeria'; // Simple assumption

                // Use firstOrCreate based on unique constraint fields (adjust if schema changes)
                // NOTE: Your schema has a complex UNIQUE constraint. This simplified approach might need adjustment.
                // It might be better to just create without firstOrCreate if duplicates aren't expected or handled differently.
                 ShippingAddress::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'street_address1' => $street,
                        // street_address2 might need more specific parsing
                        'city' => $city,
                        'state_region' => $state,
                        'country' => $country,
                         // Add postal_code, etc., if parsed and part of UNIQUE constraint
                    ],
                    [ // Only these values are set if creating new
                        // Add default values for non-unique fields if needed
                    ]
                );
            }
             // Assign the original billing address string back to the user model for use in Orders
            $user->billing_address = $originalBilling;
            $user->saveQuietly(); // Save without triggering events/timestamps if needed
        }
        $this->command->info('Users and ShippingAddresses tables seeded!');


        // --- Seed Products and Related Pivot Tables/Images/Videos ---
        foreach ($originalProducts as $productData) {
            $productId = $productData['product_id'];
            $ingredients = $productData['ingredients'] ?? [];
            $skinTypes = $productData['skin_types'] ?? [];
            $skinConcerns = $productData['skin_concerns'] ?? [];
            $images = $productData['product_images'] ?? [];
            $videos = $productData['product_videos'] ?? [];

            // Prepare product core data
            $coreProductData = [
                'product_name' => $productData['product_name'],
                'description' => $productData['description'],
                'brand_id' => $productData['brand_id'],
                'category_id' => $productData['category_id'], // Ensure category ID exists from seeding above
                'price' => $productData['price'],
                'stock_quantity' => $productData['stock_quantity'],
                'rating_average' => $productData['rating_average'] ?? 0,
                'review_count' => $productData['review_count'] ?? 0,
                 // created_at, updated_at managed by DB default
            ];

            // Seed product
            $product = Product::updateOrCreate(['id' => $productId], $coreProductData);

            // Attach Ingredients, Skin Types, Skin Concerns using IDs from maps
            $ingredientIds = collect($ingredients)->map(fn($name) => $ingredientMap[trim($name)] ?? null)->filter()->unique()->toArray();
            if (!empty($ingredientIds)) $product->ingredients()->sync($ingredientIds); // Assumes 'ingredients' relationship exists

            $skinTypeIds = collect($skinTypes)->map(fn($name) => $skinTypeMap[trim($name)] ?? null)->filter()->unique()->toArray();
            if (!empty($skinTypeIds)) $product->skinTypes()->sync($skinTypeIds); // Assumes 'skinTypes' relationship

            $skinConcernIds = collect($skinConcerns)->map(fn($name) => $skinConcernMap[trim($name)] ?? null)->filter()->unique()->toArray();
            if (!empty($skinConcernIds)) $product->skinConcerns()->sync($skinConcernIds); // Assumes 'skinConcerns' relationship

            // Seed Product Images
            foreach ($images as $imageUrl) {
                // Handle the case where the first product had [{}] which decodes to an empty array inside
                if (is_array($imageUrl) && empty($imageUrl)) continue;
                // Handle the case where it might be an object {} which decodes to stdClass
                if (is_object($imageUrl) && empty(get_object_vars($imageUrl))) continue;

                if (is_string($imageUrl) && !empty(trim($imageUrl))) {
                    ProductImage::firstOrCreate([
                        'product_id' => $product->id,
                        'image_url' => trim($imageUrl)
                    ]);
                }
            }

            // Seed Product Videos
            foreach ($videos as $videoUrl) {
                 if (is_string($videoUrl) && !empty(trim($videoUrl))) {
                    ProductVideo::firstOrCreate([
                        'product_id' => $product->id,
                        'video_url' => trim($videoUrl)
                    ]);
                }
            }
        }
        $this->command->info('Products and related tables seeded!');


        // --- Seed Orders and Order Items ---
        foreach ($originalOrders as $orderData) {
            $orderId = $orderData['order_id'];
            $orderItemsJson = $orderData['order_items'];

            // Fetch associated user to get original billing address if needed (though schema uses string)
            // $user = User::find($orderData['user_id']);

            // Prepare core order data
            $coreOrderData = [
                'user_id' => $orderData['user_id'],
                //'order_date' => $orderData['order_date'], // Let DB handle default timestamp
                'order_status' => $orderData['order_status'],
                'total_amount' => $orderData['total_amount'],
                'shipping_cost' => $orderData['shipping_cost'] ?? 0,
                'tax_amount' => $orderData['tax_amount'] ?? 0, // Default from schema
                'discount_applied' => $orderData['discount_applied'] ?? 0,
                'shipping_address' => $orderData['shipping_address'], // Keep original string as per schema
                'billing_address' => $orderData['billing_address'],   // Keep original string as per schema
                'payment_method' => $orderData['payment_method'],
                'payment_status' => $orderData['payment_status'] ?? 'Completed', // Default needed by schema (adjust as needed)
                'tracking_number' => $orderData['tracking_number'],
                 // created_at, updated_at managed by DB default
            ];

            // Seed order
            $order = Order::updateOrCreate(['id' => $orderId], $coreOrderData);

            // Seed Order Items
            $items = json_decode($orderItemsJson, true);
            if (is_array($items)) {
                foreach ($items as $item) {
                    if (isset($item['product_id']) && isset($item['quantity'])) {
                        // Use firstOrCreate to prevent duplicates if seeder runs multiple times on same order data
                         OrderItem::firstOrCreate(
                            [
                                'order_id' => $order->id,
                                'product_id' => $item['product_id'],
                            ],
                            [
                                'quantity' => $item['quantity']
                            ]
                         );
                    }
                }
            }
        }
        $this->command->info('Orders and OrderItems tables seeded!');


        // --- Seed Reviews ---
          foreach ($originalReviews as $reviewData) {
             $id = $reviewData['review_id'];
             // Use unique constraint fields for updateOrCreate check
             $uniqueData = [
                'user_id' => $reviewData['user_id'],
                'product_id' => $reviewData['product_id'],
             ];

             // Prepare review data matching schema
             $coreReviewData = [
                'rating' => $reviewData['rating'],
                'review_text' => $reviewData['review_text'],
                //'review_date' => $reviewData['review_date'], // Let DB handle default
                'is_approved' => $reviewData['is_approved'] ?? false,
                 // created_at, updated_at managed by DB default
             ];

             // Create or update based on user_id/product_id pair, ensuring the original ID is set
             Review::updateOrCreate(
                 $uniqueData,
                 array_merge(['id' => $id], $coreReviewData) // Set ID and other data
             );
        }
        $this->command->info('Reviews table seeded!');


        // Optional: Re-enable foreign key checks
        $this->command->warn('Attempting to re-enable foreign key checks (syntax may vary by DB)...');
        try {
             match (DB::connection()->getDriverName()) {
                 'mysql' => DB::statement('SET FOREIGN_KEY_CHECKS=1;'),
                 'pgsql' => DB::statement('SET CONSTRAINTS ALL IMMEDIATE;'),
                  // Add other drivers if needed
                  default => $this->command->warn('Unsupported DB driver for enabling FK checks automatically.'),
             };
             $this->command->info('Foreign key checks likely re-enabled.');
         } catch (\Exception $e) {
             $this->command->error('Could not re-enable foreign key checks: ' . $e->getMessage());
         }

        $this->command->info('Database seeding completed successfully.');
    }
}