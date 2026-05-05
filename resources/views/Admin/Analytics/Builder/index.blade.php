@extends('Layouts.app')
@section('title', 'Custom Report Builder | Analytics')
@section('content')
<div class="p-4 sm:p-6 lg:p-8 bg-bg-primary min-h-screen">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h3 font-bold text-text-primary">Custom Report Builder</h1>
            <p class="text-body-sm text-text-secondary mt-1">Select metrics, dimensions, and filters to build and save custom views.</p>
        </div>
        <div class="flex gap-2">
            <button class="btn btn-secondary px-4 py-2.5 transition-colors"><i data-lucide="bookmark" class="w-4 h-4 mr-2"></i> Saved Views</button>
            <button class="btn btn-primary px-4 py-2.5 shadow-sm transition-colors"><i data-lucide="play" class="w-4 h-4 mr-2"></i> Generate</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Controls Panel -->
        <div class="card p-6 border-border-default bg-bg-tertiary space-y-6 lg:col-span-1">
            <div class="form-group mb-0">
                <label class="form-label font-bold text-text-primary">1. Select Metrics</label>
                <select class="form-input w-full" multiple size="4">
                    <option selected>Revenue (MRR)</option>
                    <option selected>Active Jobs</option>
                    <option>Churn Rate</option>
                    <option>Customer Acquisition Cost</option>
                </select>
                <p class="text-[10px] text-text-secondary mt-1">Hold CMD/CTRL to select multiple.</p>
            </div>
            <div class="form-group mb-0">
                <label class="form-label font-bold text-text-primary">2. Select Dimensions</label>
                <select class="form-input w-full">
                    <option>By Subscription Tier</option>
                    <option>By Region</option>
                    <option>By Business Type</option>
                    <option>By Acquisition Channel</option>
                </select>
            </div>
            <div class="form-group mb-0">
                <label class="form-label font-bold text-text-primary">3. Time Frame</label>
                <select class="form-input w-full">
                    <option>Daily</option>
                    <option selected>Weekly</option>
                    <option>Monthly</option>
                </select>
            </div>
            <div class="form-group mb-0 border-t border-border-default pt-4">
                <label class="form-label font-bold text-text-primary">4. Visualization Type</label>
                <div class="flex gap-2 mt-2">
                    <button class="p-2 border border-brand-primary bg-brand-primary/10 rounded text-brand-primary"><i data-lucide="bar-chart-2" class="w-5 h-5"></i></button>
                    <button class="p-2 border border-border-default bg-bg-primary rounded text-text-tertiary hover:text-text-primary"><i data-lucide="pie-chart" class="w-5 h-5"></i></button>
                    <button class="p-2 border border-border-default bg-bg-primary rounded text-text-tertiary hover:text-text-primary"><i data-lucide="table" class="w-5 h-5"></i></button>
                </div>
            </div>
            <div class="pt-4 border-t border-border-default space-y-2">
                <button class="btn btn-secondary w-full py-2 text-brand-primary border-brand-primary/30"><i data-lucide="save" class="w-4 h-4 mr-2"></i> Save View</button>
                <button class="btn btn-secondary w-full py-2"><i data-lucide="share-2" class="w-4 h-4 mr-2"></i> Share Internally</button>
            </div>
        </div>

        <!-- Preview Panel -->
        <div class="card p-0 shadow-sm border-border-default lg:col-span-2 flex flex-col">
            <div class="p-5 border-b border-border-default bg-bg-primary flex justify-between items-center">
                <h3 class="text-h4 font-bold text-text-primary">Report Preview</h3>
                <span class="text-caption text-text-secondary">Role-based Access Enforced</span>
            </div>
            <div class="p-6 flex-1 bg-bg-secondary flex items-center justify-center min-h-[400px]">
                <div class="text-center text-text-tertiary">
                    <i data-lucide="bar-chart" class="w-12 h-12 mx-auto mb-3 opacity-50"></i>
                    <p class="text-body-sm font-bold">Revenue & Jobs by Subscription Tier</p>
                    <p class="text-caption mt-1">(Weekly Aggregation)</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection