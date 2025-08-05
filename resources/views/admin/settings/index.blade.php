@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
    <div class="fade-in">
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0">Settings</h1>
                <p class="text-muted">Customize your admin panel appearance and preferences</p>
            </div>
            <form method="POST" action="{{ route('admin.settings.reset') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline" 
                        onclick="return confirm('Are you sure you want to reset all settings to default?')">
                    <i class="bi bi-arrow-clockwise me-2"></i>
                    Reset to Default
                </button>
            </form>
        </div>

        <!-- Settings Form -->
        <div class="row">
            <div class="col-lg-8">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Theme Settings Card -->
                    <div class="admin-card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="bi bi-palette me-2"></i>
                                Theme & Colors
                            </h5>
                            <p class="text-muted mb-0">Customize the visual appearance of your admin panel</p>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <!-- Color Theme -->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="theme_color" class="form-label">Color Theme</label>
                                        <select class="form-select @error('theme_color') is-invalid @enderror" 
                                                id="theme_color" name="theme_color">
                                            @foreach($options['themes'] as $key => $label)
                                                <option value="{{ $key }}" 
                                                        {{ old('theme_color', $settings['theme']['theme_color'] ?? 'default') == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('theme_color')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Color Mode -->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="color_mode" class="form-label">Color Mode</label>
                                        <select class="form-select @error('color_mode') is-invalid @enderror" 
                                                id="color_mode" name="color_mode">
                                            @foreach($options['modes'] as $key => $label)
                                                <option value="{{ $key }}" 
                                                        {{ old('color_mode', $settings['theme']['color_mode'] ?? 'light') == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('color_mode')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Color Theme Preview -->
                            <div class="mb-4">
                                <label class="form-label">Theme Preview</label>
                                <div class="theme-preview-container">
                                    <div class="row g-2">
                                        @foreach($options['themes'] as $key => $label)
                                            <div class="col-6 col-md-3">
                                                <div class="theme-preview-card" data-theme="{{ $key }}">
                                                    <div class="theme-preview-header theme-{{ $key }}"></div>
                                                    <div class="theme-preview-content">
                                                        <div class="theme-preview-sidebar theme-{{ $key }}-muted"></div>
                                                        <div class="theme-preview-main">
                                                            <div class="theme-preview-text"></div>
                                                            <div class="theme-preview-text"></div>
                                                        </div>
                                                    </div>
                                                    <div class="theme-preview-label">{{ $label }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Typography Settings Card -->
                    <div class="admin-card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="bi bi-fonts me-2"></i>
                                Typography
                            </h5>
                            <p class="text-muted mb-0">Choose the font family for your admin panel</p>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="font_family" class="form-label">Font Family</label>
                                        <select class="form-select @error('font_family') is-invalid @enderror" 
                                                id="font_family" name="font_family">
                                            @foreach($options['fonts'] as $key => $label)
                                                <option value="{{ $key }}" 
                                                        {{ old('font_family', $settings['theme']['font_family'] ?? 'inter') == $key ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('font_family')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Font Preview</label>
                                        <div class="font-preview" id="fontPreview">
                                            <p class="mb-2">The quick brown fox jumps over the lazy dog</p>
                                            <small class="text-muted">Admin Panel Typography Sample</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Interface Settings Card -->
                    <div class="admin-card mb-4">
                        <div class="card-header">
                            <h5 class="card-title">
                                <i class="bi bi-toggles me-2"></i>
                                Interface Preferences
                            </h5>
                            <p class="text-muted mb-0">Customize the behavior of interface elements</p>
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="sidebar_collapsed" 
                                               name="sidebar_collapsed" value="1"
                                               {{ old('sidebar_collapsed', $settings['appearance']['sidebar_collapsed'] ?? false) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sidebar_collapsed">
                                            <strong>Collapse Sidebar by Default</strong>
                                            <br>
                                            <small class="text-muted">Start with the sidebar in collapsed state</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="animations_enabled" 
                                               name="animations_enabled" value="1"
                                               {{ old('animations_enabled', $settings['appearance']['animations_enabled'] ?? true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="animations_enabled">
                                            <strong>Enable Animations</strong>
                                            <br>
                                            <small class="text-muted">Show smooth transitions and animations</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2 me-2"></i>
                            Save Settings
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">
                            <i class="bi bi-arrow-left me-2"></i>
                            Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>

            <!-- Settings Info Panel -->
            <div class="col-lg-4">
                <div class="admin-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bi bi-info-circle me-2"></i>
                            Settings Info
                        </h5>
                    </div>
                    <div class="card-content">
                        <div class="mb-4">
                            <h6>Current Configuration</h6>
                            <ul class="list-unstyled small">
                                <li><strong>Theme:</strong> {{ $options['themes'][$settings['theme']['theme_color'] ?? 'default'] ?? 'Default Blue' }}</li>
                                <li><strong>Font:</strong> {{ $options['fonts'][$settings['theme']['font_family'] ?? 'inter'] ?? 'Inter' }}</li>
                                <li><strong>Mode:</strong> {{ $options['modes'][$settings['theme']['color_mode'] ?? 'light'] ?? 'Light Mode' }}</li>
                                <li><strong>Sidebar:</strong> {{ ($settings['appearance']['sidebar_collapsed'] ?? false) ? 'Collapsed' : 'Expanded' }}</li>
                                <li><strong>Animations:</strong> {{ ($settings['appearance']['animations_enabled'] ?? true) ? 'Enabled' : 'Disabled' }}</li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h6>About Themes</h6>
                            <p class="small text-muted">
                                Themes change the primary color scheme of the admin panel. 
                                Each theme includes coordinated colors for buttons, links, 
                                and accent elements.
                            </p>
                        </div>

                        <div class="mb-4">
                            <h6>Color Modes</h6>
                            <ul class="list-unstyled small text-muted">
                                <li><strong>Light:</strong> Traditional light background</li>
                                <li><strong>Dark:</strong> Dark background, easier on eyes</li>
                                <li><strong>Auto:</strong> Follows system preference</li>
                            </ul>
                        </div>

                        <div class="alert alert-info">
                            <small>
                                <i class="bi bi-lightbulb me-1"></i>
                                <strong>Tip:</strong> Changes are applied immediately after saving. 
                                You can always reset to default settings using the button above.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Theme Preview Styles */
        .theme-preview-container {
            background: hsl(var(--muted));
            padding: 1rem;
            border-radius: var(--radius);
        }

        .theme-preview-card {
            border: 2px solid transparent;
            border-radius: var(--radius);
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
        }

        .theme-preview-card:hover {
            border-color: hsl(var(--border));
            transform: translateY(-2px);
        }

        .theme-preview-card.active {
            border-color: hsl(var(--primary));
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .theme-preview-header {
            height: 20px;
        }

        .theme-preview-content {
            display: flex;
            height: 40px;
        }

        .theme-preview-sidebar {
            width: 30%;
            opacity: 0.7;
        }

        .theme-preview-main {
            flex: 1;
            padding: 4px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .theme-preview-text {
            height: 6px;
            background: #e5e7eb;
            border-radius: 2px;
        }

        .theme-preview-text:first-child {
            width: 80%;
        }

        .theme-preview-text:last-child {
            width: 60%;
        }

        .theme-preview-label {
            padding: 8px;
            text-align: center;
            font-size: 0.75rem;
            font-weight: 500;
            background: hsl(var(--muted));
        }

        /* Theme Colors */
        .theme-default { background-color: #1e40af; }
        .theme-default-muted { background-color: #dbeafe; }
        
        .theme-green { background-color: #059669; }
        .theme-green-muted { background-color: #d1fae5; }
        
        .theme-purple { background-color: #7c3aed; }
        .theme-purple-muted { background-color: #e9d5ff; }
        
        .theme-red { background-color: #dc2626; }
        .theme-red-muted { background-color: #fecaca; }
        
        .theme-black { background-color: #171717; }
        .theme-black-muted { background-color: #f5f5f5; }
        
        .theme-teal { background-color: #0891b2; }
        .theme-teal-muted { background-color: #bfdbfe; }
        
        .theme-pink { background-color: #db2777; }
        .theme-pink-muted { background-color: #fce7f3; }
        
        .theme-indigo { background-color: #4338ca; }
        .theme-indigo-muted { background-color: #e0e7ff; }

        /* Font Preview */
        .font-preview {
            padding: 1rem;
            border: 1px solid hsl(var(--border));
            border-radius: var(--radius);
            background: hsl(var(--card));
            transition: font-family 0.3s ease;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeSelect = document.getElementById('theme_color');
            const fontSelect = document.getElementById('font_family');
            const colorModeSelect = document.getElementById('color_mode');
            const fontPreview = document.getElementById('fontPreview');
            const themeCards = document.querySelectorAll('.theme-preview-card');

            // Font families mapping
            const fontFamilies = {
                'inter': '"Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                'roboto': '"Roboto", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif',
                'opensans': '"Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                'lato': '"Lato", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                'poppins': '"Poppins", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                'nunito': '"Nunito", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                'sourcesans': '"Source Sans Pro", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                'montserrat': '"Montserrat", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif'
            };

            // Update font preview
            function updateFontPreview() {
                const selectedFont = fontSelect.value;
                if (fontFamilies[selectedFont]) {
                    fontPreview.style.fontFamily = fontFamilies[selectedFont];
                }
            }

            // Update theme preview selection
            function updateThemePreview() {
                const selectedTheme = themeSelect.value;
                themeCards.forEach(card => {
                    card.classList.toggle('active', card.dataset.theme === selectedTheme);
                });
            }

            // Apply live preview to body
            function applyLivePreview() {
                const selectedTheme = themeSelect.value;
                const selectedFont = fontSelect.value;
                const selectedMode = colorModeSelect.value;
                
                // Apply theme color
                document.body.setAttribute('data-theme-color', selectedTheme);
                
                // Apply font family
                document.body.setAttribute('data-font-family', selectedFont);
                
                // Apply color mode (with auto detection)
                let actualMode = selectedMode;
                if (selectedMode === 'auto') {
                    actualMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                }
                document.body.setAttribute('data-color-mode', actualMode);
            }

            // Theme card click handlers
            themeCards.forEach(card => {
                card.addEventListener('click', function() {
                    themeSelect.value = this.dataset.theme;
                    updateThemePreview();
                    applyLivePreview();
                });
            });

            // Font select change handler
            fontSelect.addEventListener('change', function() {
                updateFontPreview();
                applyLivePreview();
            });

            // Theme select change handler
            themeSelect.addEventListener('change', function() {
                updateThemePreview();
                applyLivePreview();
            });

            // Color mode change handler
            colorModeSelect.addEventListener('change', function() {
                applyLivePreview();
            });

            // Listen for system theme changes when auto mode is selected
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                if (colorModeSelect.value === 'auto') {
                    applyLivePreview();
                }
            });

            // Initialize
            updateFontPreview();
            updateThemePreview();
            applyLivePreview();

            // Reset preview on form reset (if needed)
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('reset', function() {
                    setTimeout(function() {
                        updateFontPreview();
                        updateThemePreview();
                        applyLivePreview();
                    }, 10);
                });
            }
        });
    </script>
@endsection 
