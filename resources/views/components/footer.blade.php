<footer style="background: var(--color-surface); border-top: 1px solid var(--color-border);" class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-white text-lg"
                         style="background: linear-gradient(135deg, var(--color-accent), var(--color-secondary));">
                        {{ strtoupper(substr(\App\Models\Setting::get('full_name', 'P'), 0, 1)) }}
                    </div>
                    <span class="font-bold text-lg" style="color: var(--color-heading);">
                        {{ \App\Models\Setting::get('full_name', 'Portfolio') }}
                    </span>
                </div>
                <p class="text-sm leading-relaxed" style="color: var(--color-muted);">
                    {{ \App\Models\Setting::get(app()->getLocale() === 'ar' ? 'job_title_ar' : 'job_title', 'Full Stack Developer') }}
                </p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="font-bold mb-4" style="color: var(--color-heading);">Quick Links</h4>
                <div class="flex flex-col gap-2">
                    <a href="{{ route('home') }}#about" class="text-sm transition-colors hover:text-accent" style="color: var(--color-muted);">{{ __('navigation.about') }}</a>
                    <a href="{{ route('home') }}#skills" class="text-sm transition-colors hover:text-accent" style="color: var(--color-muted);">{{ __('navigation.skills') }}</a>
                    <a href="{{ route('projects.index') }}" class="text-sm transition-colors hover:text-accent" style="color: var(--color-muted);">{{ __('navigation.projects') }}</a>
                    <a href="{{ route('home') }}#contact" class="text-sm transition-colors hover:text-accent" style="color: var(--color-muted);">{{ __('navigation.contact') }}</a>
                </div>
            </div>

            {{-- Social Links --}}
            <div>
                <h4 class="font-bold mb-4" style="color: var(--color-heading);">Connect</h4>
                <div class="flex gap-3">
                    @if(\App\Models\Setting::get('github_url'))
                    <a href="{{ \App\Models\Setting::get('github_url') }}" target="_blank"
                       class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:-translate-y-1"
                       style="background: var(--color-card); border: 1px solid var(--color-border); color: var(--color-body);">
                        <i class="fab fa-github"></i>
                    </a>
                    @endif
                    @if(\App\Models\Setting::get('linkedin_url'))
                    <a href="{{ \App\Models\Setting::get('linkedin_url') }}" target="_blank"
                       class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:-translate-y-1"
                       style="background: var(--color-card); border: 1px solid var(--color-border); color: var(--color-body);">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    @endif
                    @if(\App\Models\Setting::get('twitter_url'))
                    <a href="{{ \App\Models\Setting::get('twitter_url') }}" target="_blank"
                       class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:-translate-y-1"
                       style="background: var(--color-card); border: 1px solid var(--color-border); color: var(--color-body);">
                        <i class="fab fa-twitter"></i>
                    </a>
                    @endif
                    @if(\App\Models\Setting::get('email'))
                    <a href="mailto:{{ \App\Models\Setting::get('email') }}"
                       class="w-10 h-10 rounded-xl flex items-center justify-center transition-all hover:-translate-y-1"
                       style="background: var(--color-card); border: 1px solid var(--color-border); color: var(--color-body);">
                        <i class="fas fa-envelope"></i>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <div style="border-top: 1px solid var(--color-border);" class="pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-sm" style="color: var(--color-muted);">
                &copy; {{ date('Y') }} {{ \App\Models\Setting::get('full_name', 'Portfolio') }}.
                {{ __('portfolio.footer_rights') }}.
            </p>
            <p class="text-sm" style="color: var(--color-muted);">
                Built with <span style="color: var(--color-danger);">❤</span> using Laravel & Tailwind CSS
            </p>
        </div>
    </div>
</footer>
