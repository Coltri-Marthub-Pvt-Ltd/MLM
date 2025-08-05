{{--
Simple Category Dropdown Component

A simple dropdown that displays categories with -- prefixes for child categories.

Usage examples:

1. Basic usage:
<x-admin.category-selector name="category_id" />

2. With custom label and required:
<x-admin.category-selector 
    name="category_id" 
    label="Product Category" 
    :required="true" />

3. With pre-selected value:
<x-admin.category-selector 
    name="category_id" 
    :value="$product->category_id" />

4. Without empty option:
<x-admin.category-selector 
    name="category_id" 
    :allowEmpty="false" />

Available props:
- name: Input name (default: 'category_id')
- id: Custom ID (default: uses name)
- value: Pre-selected value
- required: Whether field is required
- disabled: Whether field is disabled
- error: Custom error message
- label: Field label
- showLabel: Show/hide label (default: true)
- allowEmpty: Allow empty selection (default: true)
- emptyText: Text for empty option (default: 'Select Category')
- class: Additional CSS classes
--}}

@props([
    'name' => 'category_id',
    'id' => null,
    'value' => null,
    'required' => false,
    'disabled' => false,
    'error' => null,
    'label' => 'Category',
    'showLabel' => true,
    'allowEmpty' => true,
    'emptyText' => 'Select Category',
    'class' => ''
])

@php
    $componentId = $id ?? $name;
    
    // Build hierarchical category list
    $allCategories = \App\Models\Category::with('parent', 'children')->get();
    $rootCategories = $allCategories->whereNull('parent_id')->sortBy('name');
    
    function buildCategoryList($categories, $allCategories, $level = 0) {
        $list = [];
        foreach ($categories as $category) {
            $prefix = str_repeat('-- ', $level);
            $list[] = [
                'id' => $category->id,
                'name' => $prefix . $category->name,
                'level' => $level
            ];
            
            $children = $allCategories->where('parent_id', $category->id)->sortBy('name');
            if ($children->count() > 0) {
                $list = array_merge($list, buildCategoryList($children, $allCategories, $level + 1));
            }
        }
        return $list;
    }
    
    $categoryList = buildCategoryList($rootCategories, $allCategories);
@endphp

<div class="mb-3 {{ $class }}">
    @if($showLabel && $label)
        <label for="{{ $componentId }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>
    @endif
    
    <select name="{{ $name }}" 
            id="{{ $componentId }}" 
            class="form-select @error($name) is-invalid @enderror @if($error) is-invalid @endif"
            @if($required) required @endif
            @if($disabled) disabled @endif>
        
        @if($allowEmpty)
            <option value="">{{ $emptyText }}</option>
        @endif
        
        @foreach($categoryList as $category)
            <option value="{{ $category['id'] }}" 
                    @if(old($name, $value) == $category['id']) selected @endif>
                {{ $category['name'] }}
            </option>
        @endforeach
    </select>
    
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    
    @if($error)
        <div class="invalid-feedback">{{ $error }}</div>
    @endif
</div> 
    