@extends('layouts.admin.app')

@section('title', translate('messages.add_new_item'))
@section('content')
<div class="px-6 py-2">

    <!-- Tabs -->
<div class="flex space-x-4 border-b border-gray-300 bg-[#F1F5F9] shadow rounded-t-[10px]" id="tab-buttons">
  <button class="tab-btn px-4 py-4 font-semibold border-b-2 border-[#10B981] text-[#10B981] bg-white">Default</button>
  <button class="tab-btn px-4 py-4 text-[#000008]">English(EN)</button>
  <button class="tab-btn px-4 py-4 text-[#000008]">Arabic - عربي (AR)</button>
</div>



    <div class="bg-white shadow-md rounded-lg md:px-6 md:py-2">
        <div class="grid grid-cols-12  mt-4 space-y-5">
                <input type="hidden" name="hidden_value" id="hidden_value" value="1"/>
                {{--  Step 1: Select Voucher Type --}}
            <div class="col-span-12">
                <div class="bg-[#F8FAFC] p-6 rounded-lg shadow border-l-[5px] border-l-[#10B981] mt-3">
                    <h2 class="font-semibold text-lg mb-4">🎯 Step 1: Select Voucher Type</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div  aria-valuemax="Delivery" onclick="section_one('1')"  class="py-[25px] border-2 border-[#10B981]   bg-green-50 p-4 rounded-lg text-center voucher-card cursor-pointer">
                        <p class="w-full text-[30px]"> 🚚</p>
                        <p class="font-semibold">Delivery/Pickup</p>
                        <p class="text-[12px] text-[#6B7280]">E-commerce style vouchers with cart functionality</p>
                    </div>
                    <div  aria-valuemax="Store"  onclick="section_one('2')"  class="py-[25px] border p-4 rounded-lg text-center voucher-card cursor-pointer">
                        <p class="w-full text-[30px]"> 🏪</p>
                        <p class="font-semibold">In-Store</p>
                        <p class="text-[12px] text-[#6B7280]">Instant purchase with QR/Barcode redemption</p>
                    </div>
                    <div  aria-valuemax="Discount" onclick="section_one('3')"   class="py-[25px] border p-4 rounded-lg text-center voucher-card cursor-pointer">
                        <p class="w-full text-[30px]"> 💵</p>
                        <p class="font-semibold">Flat Discount</p>
                        <p class="text-[12px] text-[#6B7280]">Percentage-based discount on bill amount</p>
                    </div>
                    </div>
                </div>
            </div>
                {{-- ⚙️ Step 2: Select Management Type --}}
            <div class="col-span-12  section mt-3 management_selection" id="management_selection">
                <!-- Step 2 -->
                <div class="bg-[#F8FAFC] p-6 rounded-lg shadow border-l-[5px] border-l-[#10B981] mt-5">
                    <h2 class="font-semibold text-lg mb-4">⚙️ Step 2: Select Management Type</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div   class="py-[25px] border p-4 rounded-lg text-center voucher-card_2 cursor-pointer" onclick="section_second('4')">
                        <p class="w-full text-[30px]"> 🛒</p>
                        <p class="font-semibold">Shop</p>
                        <p class="text-[12px] text-[#6B7280]">General retail products management</p>
                    </div>
                    <div  class="py-[25px] border p-4 rounded-lg text-center voucher-card_2 cursor-pointer" onclick="section_second('5')">
                        <p class="w-full text-[30px]"> 💊</p>
                        <p class="font-semibold">Pharmacy</p>
                        <p class="text-[12px] text-[#6B7280]">Medicine and health products</p>
                    </div>
                    <div  class="py-[25px] border p-4 rounded-lg text-center voucher-card_2 cursor-pointer" onclick="section_second('6')">
                        <p class="w-full text-[30px]"> 🛒</p>
                        <p class="font-semibold">Grocery</p>
                        <p class="text-[12px] text-[#6B7280]">Food and daily essentials</p>
                    </div>
                    <div   class="py-[25px] border  p-4 rounded-lg text-center voucher-card_2 cursor-pointer" onclick="section_second('7')">
                    <p class="w-full text-[30px]"> 🍽️</p>
                        <p class="font-semibold">Food</p>
                        <p class="text-[12px] text-[#6B7280]">Restaurant and food delivery</p>
                    </div>
                    </div>
                </div>
            </div>
            <!-- Basic Information 3 1/1 1/2 1/3 1/4  2/1 2/2 2/3  2/4 -->
            <div class="col-span-12 hidden section3  mt-3 one_four_complete" id="basic_info">
                <div class="p-6 bg-[#F8FAFC] rounded-xl shadow-md  border-l-[5px] border-l-[#10B981]" >
                    <div class="text-xl font-semibold mb-6 flex items-center gap-2">
                    <span>📝</span>
                    Basic Information
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Voucher Name -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">
                        Voucher Name (Default) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" placeholder="Enter voucher name" class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                    </div>

                    <!-- Owner -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Owner</label>
                        <select class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        <option>Select owner</option>
                        <option>Arabi Valu</option>
                        <option>TNB</option>
                        <option>Jawwal</option>
                        </select>
                    </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <!-- Owner Segments -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Owner Segments</label>
                        <select class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        <option>Select segment</option>
                        <option>VIP</option>
                        <option>Elite</option>
                        <option>Premium</option>
                        </select>
                    </div>

                    <!-- Empty column -->
                    <div></div>
                    </div>

                    <!-- Description -->
                    <div class="flex flex-col mt-4">
                    <label class="text-sm font-medium mb-1">
                        Short Description (Default) <span class="text-red-500">*</span>
                    </label>
                    <textarea placeholder="Enter voucher description" class="px-3 py-2 border rounded-md h-28 resize-none focus:outline-none focus:ring focus:border-blue-300"></textarea>
                    </div>

                    <!-- Uploads -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <!-- Voucher Image -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Voucher Image (Ratio 1:1)</label>
                        <div class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-md p-6 text-gray-500">
                        <div class="text-3xl">📷</div>
                        <div>Upload Image</div>
                        </div>
                    </div>

                    <!-- Voucher Thumbnail -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Voucher Thumbnail (Ratio 1:1)</label>
                        <div class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-md p-6 text-gray-500">
                        <div class="text-3xl">🖼️</div>
                        <div>Upload Image</div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Discount Store & Category Info 3 -->
            <div class="col-span-12 hidden section3  mt-3" id="discount_store_category">
                <div class="p-6 bg-[#F8FAFC] rounded-xl shadow-md  border-l-[5px] border-l-[#10B981]" >
                    <div class="text-xl font-semibold mb-6 flex items-center gap-2">
                    <span>🏪</span>
                    Store &amp; Category Info
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Partner Store -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">
                        Partner Store <span class="text-red-500">*</span>
                        </label>
                        <select class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        <option>Select partner store</option>
                        <option>Teh Kotjok - SGC Cikarang</option>
                        <option>McDonald's Riyadh</option>
                        <option>Burger King Jeddah</option>
                        <option>Pizza Hut Dammam</option>
                        </select>
                    </div>

                    <!-- Category -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">
                        Category <span class="text-red-500">*</span>
                        </label>
                        <select class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        <option>Select category</option>
                        <option>Restaurant</option>
                        <option>Cafe</option>
                        <option>Fast Food</option>
                        <option>Fine Dining</option>
                        </select>
                    </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <!-- Service Type -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Service Type</label>
                        <select class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        <option>Dine In Only</option>
                        <option>Delivery Only</option>
                        <option>Dine In &amp; Delivery</option>
                        </select>
                    </div>

                    <!-- Location/Branch -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Location/Branch</label>
                        <select class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        <option>All Branches</option>
                        <option>Specific Branch</option>
                        <option>Multiple Selected Branches</option>
                        </select>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Discount Settings 3 -->
            <div class="col-span-12 hidden section3  mt-3" id="discount_settings">
                <div class="p-6 bg-[#F8FAFC] rounded-xl shadow-md  border-l-[5px] border-l-[#10B981]" >
                    <div class="text-xl font-semibold mb-6 flex items-center gap-2">
                    <span>💰</span>
                    Discount Configuration
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Discount Type -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">
                        Discount Type <span class="text-red-500">*</span>
                        </label>
                        <select class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        <option>Percentage (%)</option>
                        <option>Fixed Amount (SAR)</option>
                        </select>
                    </div>

                    <!-- Discount Value -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">
                        Discount Value <span class="text-red-500">*</span>
                        </label>
                        <input type="number" placeholder="Ex: 15" step="0.01" class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                    </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <!-- Minimum Bill Amount -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">
                        Minimum Bill Amount (SAR) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" placeholder="Ex: 20000" step="0.01" class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                    </div>

                    <!-- Maximum Discount Cap -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Maximum Discount Cap (SAR)</label>
                        <input type="number" placeholder="Leave empty for unlimited" step="0.01" class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                    </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <!-- Valid Until -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">
                        Valid Until Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" value="2025-12-31" class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                    </div>

                    <!-- Usage Limit per User -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Usage Limit per User</label>
                        <input type="number" placeholder="Ex: 1 (leave empty for unlimited)" class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                    </div>
                    </div>

                    <!-- Checkbox Options -->
                    <div class="mt-6 grid grid-cols-1 gap-2">
                    <div class="flex items-start gap-2">
                        <input type="checkbox" id="no-discount-cap" checked class="mt-1 accent-blue-600">
                        <label for="no-discount-cap" class="text-sm">No discount cap (like Grab example)</label>
                    </div>
                    <div class="flex items-start gap-2">
                        <input type="checkbox" id="unlimited-redemptions" checked class="mt-1 accent-blue-600">
                        <label for="unlimited-redemptions" class="text-sm">Unlimited redemptions</label>
                    </div>
                    <div class="flex items-start gap-2">
                        <input type="checkbox" id="stackable-offers" class="mt-1 accent-blue-600">
                        <label for="stackable-offers" class="text-sm">Check with outlet if stackable with other offers</label>
                    </div>
                    <div class="flex items-start gap-2">
                        <input type="checkbox" id="anytime-redemption" checked class="mt-1 accent-blue-600">
                        <label for="anytime-redemption" class="text-sm">Redeemable anytime during opening hours</label>
                    </div>
                    </div>
                </div>
            </div>
            {{-- Store Category Info 3 1/1 1/2 1/3 1/4  2/1 2/2 2/3 2/4--}}
            <div class="col-span-12 hidden section3  mt-3 one_four_complete two_four_complete" id="store_category">
                <div class="p-6 bg-[#F8FAFC] rounded-xl shadow-md  border-l-[5px] border-l-[#10B981]" >
                    <div class="text-xl font-semibold mb-6 flex items-center gap-2">
                    <span>🏪</span>
                    Store &amp; Category Info
                    </div>

                    <!-- Shop Fields -->
                    <div class="hidden" id="shop-category-fields">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Store -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Store <span class="text-red-500">*</span></label>
                            <select class="form-select">
                                <option>Select store</option>
                                <option>Main Store</option>
                                <option>Branch 1</option>
                                <option>Branch 2</option>
                            </select>
                            </div>
                            <!-- Category -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Category <span class="text-red-500">*</span></label>
                            <select class="form-select">
                                <option>Select category</option>
                                <option>Electronics</option>
                                <option>Fashion</option>
                                <option>Home &amp; Garden</option>
                            </select>
                            </div>
                            <!-- Sub Category -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Sub Category</label>
                            <select class="form-select">
                                <option>Select sub category</option>
                            </select>
                            </div>
                            <!-- Brand -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Brand</label>
                            <select class="form-select">
                                <option>Select brand</option>
                                <option>Brand A</option>
                                <option>Brand B</option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <!-- Pharmacy Fields -->
                    <div class="hidden mt-6" id="pharmacy-category-fields">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Store -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Store <span class="text-red-500">*</span></label>
                            <select class="form-select">
                                <option>Select store</option>
                                <option>Main Pharmacy</option>
                                <option>Branch Pharmacy</option>
                            </select>
                            </div>
                            <!-- Category -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Category <span class="text-red-500">*</span></label>
                            <select class="form-select">
                                <option>Select category</option>
                                <option>Prescription Medicine</option>
                                <option>Over Counter</option>
                                <option>Health Products</option>
                            </select>
                            </div>
                            <!-- Sub Category -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Sub Category</label>
                            <select class="form-select">
                                <option>Select sub category</option>
                            </select>
                            </div>
                            <!-- Suitable For -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Suitable For</label>
                            <select class="form-select">
                                <option>Select Condition</option>
                                <option>Adults</option>
                                <option>Children</option>
                                <option>Elderly</option>
                            </select>
                            </div>
                            <!-- Unit -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Unit</label>
                            <select class="form-select">
                                <option>Kg</option>
                                <option>Piece</option>
                                <option>Box</option>
                                <option>Bottle</option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <!-- Grocery Fields -->
                    <div class="hidden mt-6" id="grocery-category-fields">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Store -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Store <span class="text-red-500">*</span></label>
                            <select class="form-select">
                                <option>Select store</option>
                                <option>Main Grocery</option>
                                <option>Supermarket Branch</option>
                            </select>
                            </div>
                            <!-- Category -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Category <span class="text-red-500">*</span></label>
                            <select class="form-select">
                                <option>Select category</option>
                                <option>Fresh Produce</option>
                                <option>Dairy</option>
                                <option>Packaged Foods</option>
                            </select>
                            </div>
                            <!-- Sub Category -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Sub Category</label>
                            <select class="form-select">
                                <option>Select sub category</option>
                            </select>
                            </div>
                            <!-- Unit -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Unit</label>
                            <select class="form-select">
                                <option>Kg</option>
                                <option>Piece</option>
                                <option>Package</option>
                                <option>Liter</option>
                            </select>
                            </div>
                        </div>
                    </div>

                    <!-- Food Fields -->
                    <div class="hidden mt-6" id="food-category-fields">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Store -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Store <span class="text-red-500">*</span></label>
                            <select class="form-select">
                                <option>Select store</option>
                                <option>Main Restaurant</option>
                                <option>Food Court</option>
                                <option>Delivery Kitchen</option>
                            </select>
                            </div>
                            <!-- Category -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Category <span class="text-red-500">*</span></label>
                            <select class="form-select">
                                <option>Select category</option>
                                <option>Main Dishes</option>
                                <option>Appetizers</option>
                                <option>Desserts</option>
                                <option>Beverages</option>
                            </select>
                            </div>
                            <!-- Sub Category -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Sub Category</label>
                            <select class="form-select">
                                <option>Select sub category</option>
                            </select>
                            </div>
                            <!-- Item Type -->
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Item Type <span class="text-red-500">*</span></label>
                            <select class="form-select">
                                <option>Non veg</option>
                                <option>Veg</option>
                                <option>Halal</option>
                            </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shop Management Settings 1/3 2/1-->
            <div class="col-span-12 section hidden mt-3" id="shop_fields">
                <div class="p-6 bg-[#F8FAFC] rounded-xl shadow-md  border-l-[5px] border-l-[#10B981]" >
                    <div class="text-xl font-semibold mb-6 flex items-center gap-2">
                    <span>🛒</span>
                    Shop Management Settings
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Max Purchase Quantity -->
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Maximum Purchase Quantity Limit</label>
                        <input
                        type="number"
                        placeholder="Ex: 10"
                        class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>

                    <!-- Empty column (optional) -->
                    <div></div>
                    </div>
                </div>
            </div>

            <!-- Pharmacy Management Fields 1/1 1/2 1/3 1/4  2/2 2/3 2/4-->
            <div class="col-span-12 section hidden mt-3 one_four_complete" id="pharmacy_fields">
                <div class="p-6 bg-[#F8FAFC] rounded-xl shadow-md  border-l-[5px] border-l-[#10B981]" >
                    <div class="text-xl font-semibold mb-6 flex items-center gap-2">
                    <span>💊</span>
                    Pharmacy Management Settings
                    </div>

                    <!-- Max Purchase Quantity -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Maximum Purchase Quantity Limit</label>
                        <input
                        type="number"
                        placeholder="Ex: 10"
                        class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div></div>
                    </div>

                    <!-- Checkboxes -->
                    <div class="mt-6 space-y-2">
                    <div class="flex items-start gap-2">
                        <input type="checkbox" id="is-basic-medicine" class="mt-1 accent-blue-600">
                        <label for="is-basic-medicine" class="text-sm">Is Basic Medicine</label>
                    </div>
                    <div class="flex items-start gap-2">
                        <input type="checkbox" id="is-prescription-required" class="mt-1 accent-blue-600">
                        <label for="is-prescription-required" class="text-sm">Is prescription required</label>
                    </div>
                    </div>

                    <!-- Generic Name -->
                    <div class="mt-6 flex flex-col">
                    <label class="text-sm font-medium mb-1">Generic name</label>
                    <input
                        type="text"
                        placeholder="Enter generic name"
                        class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                    />
                    </div>
                </div>
            </div>

            <!-- Grocery Management Fields 1/3 1/4 2/3 2/4-->
            <div class="col-span-12 section hidden mt-3" id="grocery_fields">
                <div class="p-6 bg-[#F8FAFC] rounded-xl shadow-md  border-l-[5px] border-l-[#10B981] mt-8" >
                    <div class="text-xl font-semibold mb-6 flex items-center gap-2">
                    <span>🛒</span>
                    Grocery Management Settings
                    </div>

                    <!-- Nutrition & Allergen Ingredients -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Nutrition</label>
                        <textarea
                        placeholder="Type your content and press enter"
                        class="px-3 py-2 border rounded-md h-28 resize-none focus:outline-none focus:ring focus:border-blue-300"
                        ></textarea>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Allergen Ingredients</label>
                        <textarea
                        placeholder="Type your content and press enter"
                        class="px-3 py-2 border rounded-md h-28 resize-none focus:outline-none focus:ring focus:border-blue-300"
                        ></textarea>
                    </div>
                    </div>

                    <!-- Max Purchase Quantity -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Maximum Purchase Quantity Limit</label>
                        <input
                        type="number"
                        placeholder="Ex: 10"
                        class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300"
                        />
                    </div>
                    <div></div>
                    </div>

                    <!-- Checkboxes -->
                    <div class="mt-6 space-y-2">
                    <div class="flex items-start gap-2">
                        <input type="checkbox" id="is-organic" class="mt-1 accent-green-600">
                        <label for="is-organic" class="text-sm">Is organic</label>
                    </div>
                    <div class="flex items-start gap-2">
                        <input type="checkbox" id="is-halal" class="mt-1 accent-green-600">
                        <label for="is-halal" class="text-sm">Is It Halal</label>
                    </div>
                    </div>
                </div>
            </div>

                <!-- Food Management Fields 1/4 2/4-->
            <div class="col-span-12 section hidden mt-3" id="food_fields">
                <div class="p-6 bg-[#F8FAFC] rounded-xl shadow-md  border-l-[5px] border-l-[#10B981] space-y-8" >
                    <!-- Title -->
                    <div class="text-xl font-semibold flex items-center gap-2">
                    <span>🍽️</span>
                    Food Management Settings
                    </div>

                    <!-- Nutrition and Allergen Ingredients -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Nutrition</label>
                        <textarea class="px-3 py-2 border rounded-md h-28 resize-none focus:outline-none focus:ring focus:border-blue-300"
                                placeholder="Type your content and press enter"></textarea>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Allergen Ingredients</label>
                        <textarea class="px-3 py-2 border rounded-md h-28 resize-none focus:outline-none focus:ring focus:border-blue-300"
                                placeholder="Type your content and press enter"></textarea>
                    </div>
                    </div>

                    <!-- Max Purchase Quantity -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Maximum Purchase Quantity Limit</label>
                        <input type="number" placeholder="Ex: 10"
                            class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" />
                    </div>
                    <div></div>
                    </div>

                    <!-- Halal Checkbox -->
                    <div class="flex items-start gap-2">
                    <input type="checkbox" id="is-halal-food" class="mt-1 accent-green-600">
                    <label for="is-halal-food" class="text-sm">Is It Halal</label>
                    </div>

                    <!-- Addon Section -->
                    <div class="pt-4 border-t">
                    <div class="text-lg font-medium mb-4 flex items-center gap-2">
                        <span>🧩</span>
                        Addon
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Addon</label>
                        <select class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        <option>Select addon</option>
                        <option>Extra Cheese</option>
                        <option>Extra Sauce</option>
                        </select>
                    </div>
                    </div>

                    <!-- Time Schedule Section -->
                    <div class="pt-4 border-t">
                    <div class="text-lg font-medium mb-4 flex items-center gap-2">
                        <span>⏰</span>
                        Time Schedule
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Available time starts</label>
                        <input type="time" class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" />
                        </div>
                        <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Available time ends</label>
                        <input type="time" class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" />
                        </div>
                    </div>
                    </div>

                    <!-- Food Variations Section -->
                    <div class="pt-4 border-t">
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-lg font-medium flex items-center gap-2">
                        <span>🔄</span>
                        Food Variations
                        </div>
                        <button type="button"
                                class="text-sm px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Add new variation +
                        </button>
                    </div>

                    <div class="text-center text-gray-500">
                        <div class="text-5xl mb-2">📦</div>
                        <div>No variation added</div>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Price Information 1/1 1/2 1/3 1/4  2/1 2/2 2/3 2/4-->
            <div class="col-span-12 hidden section mt-3 one_four_complete two_four_complete" id="price_info">
                <div class="p-6 bg-[#F8FAFC] rounded-xl shadow-md  border-l-[5px] border-l-[#10B981] space-y-8" >
                    <!-- Section Title -->
                    <div class="text-xl font-semibold flex items-center gap-2">
                    <span>💰</span>
                    Price Information
                    </div>

                    <!-- Price & Total Stock -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Price <span class="text-red-500">*</span></label>
                        <input type="number" value="1" step="0.01"
                            class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" />
                    </div>
                    <div class="flex flex-col" id="total-stock-field">
                        <label class="text-sm font-medium mb-1">Total Stock</label>
                        <input type="number" placeholder="Ex: 100"
                            class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" />
                    </div>
                    </div>

                    <!-- Discount Type & Discount Value -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Discount Type</label>
                        <select class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                        <option>Percent (%)</option>
                        <option>Fixed Amount</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Discount (%)</label>
                        <input type="number" value="0"
                            class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" />
                    </div>
                    </div>

                    <!-- Discount-Specific Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 hidden" id="discount-specific-fields">
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Minimum Bill Amount (SAR)</label>
                        <input type="number" placeholder="Ex: 50"
                            class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" />
                    </div>
                    <div class="flex flex-col">
                        <label class="text-sm font-medium mb-1">Maximum Discount Cap (SAR)</label>
                        <input type="number" placeholder="Ex: 100"
                            class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" />
                    </div>
                    </div>
                </div>
            </div>

            <!-- Voucher Behavior Settings 3 1/1  1/2 1/3 1/4 2/1 2/2 2/3 2/4-->
            <div class="col-span-12 hidden section3 mt-3 two_four_complete" id="voucher_behavior">
                <div class="p-6 bg-[#F8FAFC] rounded-xl shadow-md  border-l-[5px] border-l-[#10B981] space-y-8" >
                    <!-- Section Title -->
                    <div class="text-xl font-semibold flex items-center gap-2">
                    <span>⚙️</span>
                    Voucher Behavior Settings
                    </div>
                    <!-- Delivery/Pickup Specific -->
                    <div class="" id="delivery-behavior">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                            <input type="checkbox" id="enable-cart">
                            <label for="enable-cart">Enable Cart Functionality</label>
                            </div>
                            <div class="flex items-center gap-2">
                            <input type="checkbox" id="enable-tracking">
                            <label for="enable-tracking">Enable Order Tracking</label>
                            </div>
                            <div class="flex items-center gap-2">
                            <input type="checkbox" id="allow-scheduled">
                            <label for="allow-scheduled">Allow Scheduled Delivery</label>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Delivery Areas</label>
                            <select multiple class="border rounded-md p-2">
                                <option>Central Riyadh</option>
                                <option>North Riyadh</option>
                                <option>East Riyadh</option>
                                <option>West Riyadh</option>
                            </select>
                            </div>
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Delivery Fee (SAR)</label>
                            <input type="number" class="border rounded-md p-2" placeholder="Ex: 15">
                            </div>
                        </div>
                    </div>
                    <!-- In-Store Specific -->
                    <div class="hidden" id="instore-behavior">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">QR Code Type</label>
                            <select class="border rounded-md p-2">
                                <option>Dynamic QR</option>
                                <option>Static QR</option>
                                <option>QR + Barcode</option>
                            </select>
                            </div>
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Redemption Method</label>
                            <select class="border rounded-md p-2">
                                <option>Scan to Redeem</option>
                                <option>Code Entry</option>
                                <option>Both</option>
                            </select>
                            </div>
                        </div>
                        <div class="space-y-2 mt-4">
                            <div class="flex items-center gap-2">
                            <input type="checkbox" id="instant-redeem">
                            <label for="instant-redeem">Allow Instant Redemption</label>
                            </div>
                            <div class="flex items-center gap-2">
                            <input type="checkbox" id="partial-redeem">
                            <label for="partial-redeem">Allow Partial Redemption</label>
                            </div>
                            <div class="flex items-center gap-2">
                            <input type="checkbox" id="buy-now-only">
                            <label for="buy-now-only">Buy Now Only (No Cart)</label>
                            </div>
                        </div>
                    </div>
                    <!-- Discount Behavior -->
                    <div id="discount-behavior" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Discount Type</label>
                            <select class="border rounded-md p-2">
                                <option>Percentage (%)</option>
                                <option>Fixed Amount (SAR)</option>
                            </select>
                            </div>
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Discount Value</label>
                            <input type="number" class="border rounded-md p-2" placeholder="Ex: 15">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Minimum Bill Amount (SAR)</label>
                            <input type="number" class="border rounded-md p-2" placeholder="Ex: 20000">
                            </div>
                            <div class="flex flex-col">
                            <label class="text-sm font-medium mb-1">Maximum Discount Cap (SAR)</label>
                            <input type="number" class="border rounded-md p-2" placeholder="Leave empty for no cap">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                            <input type="checkbox" id="cashless-only" checked disabled>
                            <label for="cashless-only">Cashless Payment Only (Required)</label>
                            </div>
                            <div class="flex items-center gap-2">
                            <input type="checkbox" id="bill-calculator" checked>
                            <label for="bill-calculator">Enable Bill Calculator Interface</label>
                            </div>
                            <div class="flex items-center gap-2">
                            <input type="checkbox" id="auto-calculation">
                            <label for="auto-calculation">Auto Calculate Discounted Amount</label>
                            </div>
                            <div class="flex items-center gap-2">
                            <input type="checkbox" id="show-breakdown">
                            <label for="show-breakdown">Show Payment Breakdown</label>
                            </div>
                        </div>
                        <!-- Payment Methods -->
                        <div class="pt-4 border-t">
                            <div class="text-lg font-semibold flex items-center gap-2 mb-4">
                            <span>💳</span>
                            Allowed Payment Methods (Cashless Only)
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" id="credit-debit-cards" checked>
                                    <label for="credit-debit-cards">Credit/Debit Cards (Visa, MasterCard, Mada)</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" id="apple-pay" checked>
                                    <label for="apple-pay">Apple Pay</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" id="wallet-payment" checked>
                                    <label for="wallet-payment">Digital Wallet</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" id="bank-transfer">
                                    <label for="bank-transfer">Bank Transfer</label>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" id="stc-pay">
                                    <label for="stc-pay">STC Pay</label>
                                </div>
                            </div>
                        </div>
                        <!-- Voucher Display Settings -->
                        <div class="pt-4 border-t">
                            <div class="text-lg font-semibold flex items-center gap-2 mb-4">
                            <span>🎨</span>
                            Voucher Display Settings
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <label class="text-sm font-medium mb-1">Display Title Template</label>
                                <input type="text" class="border rounded-md p-2" value="{discount}% off total bill">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-sm font-medium mb-1">Subtitle Template</label>
                                <input type="text" class="border rounded-md p-2" value="SAR{minimum} minimum spend">
                            </div>
                            </div>
                            <div class="mt-4">
                            <label class="text-sm font-medium mb-1">Cashless Payment Notice</label>
                            <textarea class="border rounded-md p-2 w-full">Cashless Payment Only - Credit/Debit Cards, Apple Pay, and Digital Wallet accepted</textarea>
                            </div>
                            <div class="space-y-2 mt-2">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="show-partner-logo" checked>
                                <label for="show-partner-logo">Show Partner Logo on Voucher</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="show-cashless-badge" checked>
                                <label for="show-cashless-badge">Show "Cashless Only" Badge</label>
                            </div>
                            </div>
                        </div>
                        <!-- Bill Input Settings -->
                        <div class="pt-4 border-t">
                            <div class="text-lg font-semibold flex items-center gap-2 mb-4">
                            <span>🧮</span>
                            Bill Input Interface Settings
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <label class="text-sm font-medium mb-1">Bill Input Label</label>
                                <input type="text" class="border rounded-md p-2" value="Enter amount on receipt">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-sm font-medium mb-1">Currency Symbol</label>
                                <select class="border rounded-md p-2">
                                <option>SAR</option>
                                <option>USD</option>
                                <option>AED</option>
                                </select>
                            </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                            <div class="flex flex-col">
                                <label class="text-sm font-medium mb-1">Number Pad Style</label>
                                <select class="border rounded-md p-2">
                                <option>Full Screen Calculator</option>
                                <option>Compact Keyboard</option>
                                <option>Native Input</option>
                                </select>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-sm font-medium mb-1">Decimal Places</label>
                                <select class="border rounded-md p-2">
                                <option>0</option>
                                <option>2</option>
                                <option>3</option>
                                </select>
                            </div>
                            </div>
                            <div class="space-y-2 mt-4">
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="show-calculation-preview" checked>
                                <label for="show-calculation-preview">Show Real-time Calculation Preview</label>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" id="highlight-savings">
                                <label for="highlight-savings">Highlight Savings Amount</label>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usage Terms & Conditions 3 1/1 1/2 1/3 1/4 2/1 2/2 2/3 2/4-->
            <div class="col-span-12 hidden section3 mt-3 one_four_complete two_four_complete" id="usage_terms">
                <div class="p-6 bg-[#F8FAFC] rounded-xl shadow  border-l-[5px] border-l-[#10B981]" >
                    <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <span>📋</span> Usage Terms &amp; Conditions
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" id="valid-in-store" class="form-checkbox">
                            <span>Valid in-store only</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" id="redeem-schedule" class="form-checkbox">
                            <span>Redeem on Mon–Sun 10:00am – 10:00pm. Including public holidays</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" id="valid-30-days" class="form-checkbox">
                            <span>Valid for 30 days after purchase</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" id="one-per-bill" class="form-checkbox">
                            <span>Limited to 1 voucher per bill</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" id="non-refundable" class="form-checkbox">
                            <span>Non-refundable</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" id="unlimited-purchase" class="form-checkbox">
                            <span>Unlimited purchase for user</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" id="prior-booking" class="form-checkbox">
                            <span>Prior booking is required</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" id="no-holidays" class="form-checkbox">
                            <span>Offers does not include official holidays</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" id="no-ramadan" class="form-checkbox">
                            <span>Offers does not include Ramadan</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" id="included-brands" class="form-checkbox">
                            <span>Included brands</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" id="higher-price-apply" class="form-checkbox">
                            <span>The higher price will apply if the products do not match</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" id="redeemable-branches" class="form-checkbox">
                            <span>Redeemable at 4 branches</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                        <div class="form-group">
                            <label class="form-label block mb-1">Valid Until Date</label>
                            <input type="date" class="form-control w-full border rounded px-3 py-2" value="2025-12-31">
                        </div>
                        <div class="form-group">
                            <label class="form-label block mb-1">Usage Limit per User</label>
                            <input type="number" class="form-control w-full border rounded px-3 py-2" placeholder="Ex: 1">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attributes  1/1 1/2 1/3 1/4 2/1 2/2 2/3 2/4-->
            <div class="col-span-12 hidden section mt-3 one_four_complete two_four_complete"  id="attributes">
                <div class="bg-[#F8FAFC] rounded-xl shadow  border-l-[5px] border-l-[#10B981] p-6 space-y-4">
                    <div class="text-xl font-semibold text-gray-800 flex items-center space-x-2">
                    <span>🏷️</span>
                    <span>Attributes</span>
                    </div>
                    <div class="flex flex-col space-y-2">
                    <label class="text-sm font-medium text-gray-700">Attribute</label>
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option>Select attribute</option>
                        <option>Size</option>
                        <option>Color</option>
                        <option>Material</option>
                    </select>
                    </div>
                </div>
            </div>
            {{-- Tags 3 1/1 1/2  1/3 1/4 2/1 2/2 2/3 2/4--}}
            <div class="col-span-12 hidden section3 mt-3 two_four_complete" id="tags">
                <div  class="bg-[#F8FAFC] rounded-xl shadow  border-l-[5px] border-l-[#10B981] p-6 space-y-4">
                    <div class="text-xl font-semibold text-gray-800 flex items-center space-x-2">
                    <span>🏷️</span>
                    <span>Tags</span>
                    </div>
                    <div class="flex flex-col space-y-2">
                    <input
                        type="text"
                        class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                        placeholder="Search tags"
                    />
                    </div>
                </div>
            </div>
                <!-- Buttons -->
            <div class="col-span-12">
                <div class="flex justify-end space-x-4 my-4">
                    <button class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Reset</button>
                    <button class="px-4 py-2 bg-[#10B981] text-white rounded hover:bg-green-700">Submit</button>
                </div>
            </div>
        </div>
    </div>



@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
@push('script_data')


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const managementSelection = document.querySelectorAll('.management_selection');
        const voucherCards = document.querySelectorAll('.voucher-card');
        const voucherCards2 = document.querySelectorAll('.voucher-card_2');

        // Get all elements by ID
        const basic_info = document.getElementById('basic_info');
        const discount_store_category = document.getElementById('discount_store_category');
        const discount_settings = document.getElementById('discount_settings');
        const store_category = document.getElementById('store_category');
        const shop_fields = document.getElementById('shop_fields');
        const pharmacy_fields = document.getElementById('pharmacy_fields');
        const grocery_fields = document.getElementById('grocery_fields');
        const food_fields = document.getElementById('food_fields');
        const price_info = document.getElementById('price_info');
        const voucher_behavior = document.getElementById('voucher_behavior');
        const usage_terms = document.getElementById('usage_terms');
        const attributes = document.getElementById('attributes');
        const tags = document.getElementById('tags');

        // Function to toggle visibility based on selection
        function section_one(value_one) {
        document.getElementById('hidden_value').value = value_one;

            managementSelection.forEach(el => {
                if (value_one === "1" || value_one === "2") {
                    el.classList.remove('hidden');
                    // add 'hidden' class
                    [basic_info, discount_store_category, discount_settings, store_category, voucher_behavior, usage_terms, tags].forEach(el => {
                        if (el) el.classList.add('hidden');
                    });

                } else if (value_one === "3") {
                    el.classList.add('hidden');
                    // Remove 'hidden' class
                    [basic_info, discount_store_category, discount_settings, store_category, voucher_behavior, usage_terms, tags].forEach(el => {
                        if (el) el.classList.remove('hidden');
                    });
                }
            });
        }

    function section_second(value_two) {
        const hidden_value = document.getElementById('hidden_value').value;

        switch (hidden_value) {
            case "1":
                switch (value_two) {
                    case "4":
                        // logic for 4-1
                        [basic_info, store_category ,pharmacy_fields,price_info,voucher_behavior,usage_terms,attributes ,tags].forEach(el => {
                        if (el) el.classList.remove('hidden');
                        });
                        [discount_store_category,discount_settings,shop_fields,grocery_fields,food_fields].forEach(el => {
                        if (el) el.classList.add('hidden');
                        });
                        break;
                    case "5":
                        [basic_info, store_category ,pharmacy_fields,price_info,voucher_behavior,usage_terms,attributes ,tags].forEach(el => {
                        if (el) el.classList.remove('hidden');
                        });
                        [discount_store_category,discount_settings,shop_fields,grocery_fields,food_fields].forEach(el => {
                        if (el) el.classList.add('hidden');
                        });
                        break;
                    case "6":
                        // logic for 6-1
                            [basic_info, store_category,shop_fields ,pharmacy_fields,grocery_fields,price_info,voucher_behavior,usage_terms,attributes ,tags].forEach(el => {
                            if (el) el.classList.remove('hidden');
                            });
                            [discount_store_category,discount_settings,food_fields].forEach(el => {
                            if (el) el.classList.add('hidden');
                            });
                        break;
                    case "7":
                        // logic for 7-1
                            [basic_info, store_category ,pharmacy_fields,grocery_fields,food_fields,price_info,voucher_behavior,usage_terms,attributes ,tags].forEach(el => {
                            if (el) el.classList.remove('hidden');
                            });
                            [discount_store_category,discount_settings,shop_fields].forEach(el => {
                            if (el) el.classList.add('hidden');
                            });
                        break;
                }
                break;

            case "2":
                switch (value_two) {
                    case "4":
                        // logic for 4-2
                        [basic_info, store_category ,shop_fields,price_info,voucher_behavior,usage_terms,attributes ,tags].forEach(el => {
                        if (el) el.classList.remove('hidden');
                        });
                        [discount_store_category,discount_settings,pharmacy_fields,grocery_fields,food_fields].forEach(el => {
                        if (el) el.classList.add('hidden');
                        });

                        break;
                    case "5":
                        // logic for 5-2
                        [basic_info , store_category, pharmacy_fields, price_info, voucher_behavior, usage_terms ,attributes, tags].forEach(el => {
                        if (el) el.classList.remove('hidden');
                        });
                        [discount_store_category,discount_settings,shop_fields,grocery_fields,food_fields].forEach(el => {
                        if (el) el.classList.add('hidden');
                        });
                        break;
                    case "6":
                        // logic for 6-2
                        [basic_info , store_category ,pharmacy_fields ,grocery_fields ,price_info ,voucher_behavior ,usage_terms ,attributes, tags].forEach(el => {
                        if (el) el.classList.remove('hidden');
                        });
                        [discount_store_category,pharmacy_fields,discount_settings,shop_fields,food_fields].forEach(el => {
                        if (el) el.classList.add('hidden');
                        });
                        break;
                    case "7":
                        // logic for 7-2
                        [basic_info ,store_category,pharmacy_fields,grocery_fields,food_fields,price_info,voucher_behavior,usage_terms,attributes,tags].forEach(el => {
                        if (el) el.classList.remove('hidden');
                        });
                        [discount_store_category,discount_settings,shop_fields].forEach(el => {
                        if (el) el.classList.add('hidden');
                        });
                        break;
                }
                break;

            case "3":
                if (value_two === "4") {
                    // logic for 4-3
                        [basic_info,discount_store_category,discount_settings,store_category,voucher_behavior,usage_terms,attributes,tags].forEach(el => {
                    if (el) el.classList.remove('hidden');
                    });
                    [pharmacy_fields,shop_fields,grocery_fields,food_fields,price_info].forEach(el => {
                    if (el) el.classList.add('hidden');
                    });

                }
                break;
        }
    }


    // Highlight selected voucher-card
    voucherCards.forEach(card => {
        card.addEventListener('click', function () {
            voucherCards.forEach(c => c.classList.remove('border-2', 'border-[#10B981]', 'bg-green-50'));
            this.classList.add('border-2', 'border-[#10B981]', 'bg-green-50');
        });
    });

    // Highlight selected management voucher-card
    voucherCards2.forEach(card => {
        card.addEventListener('click', function () {
            voucherCards2.forEach(c => c.classList.remove('border-2', 'border-[#10B981]', 'bg-green-50'));
            this.classList.add('border-2', 'border-[#10B981]', 'bg-green-50');
        });
    });

    // Make functions globally accessible if used in HTML
    window.section_one = section_one;
    window.section_second = section_second;
});
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab-btn');

    tabs.forEach(tab => {
      tab.addEventListener('click', function () {
        // Remove active classes from all
        tabs.forEach(btn => {
          btn.classList.remove('border-b-2', 'border-[#10B981]', 'text-[#10B981]', 'bg-white', 'font-semibold');
          btn.classList.add('text-[#000008]');
        });

        // Add active classes to clicked tab
        this.classList.add('border-b-2', 'border-[#10B981]', 'text-[#10B981]', 'bg-white', 'font-semibold');
        this.classList.remove('text-[#000008]');
      });
    });
  });
</script>

@endpush
