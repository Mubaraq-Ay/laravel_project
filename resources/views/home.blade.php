<x-layout>
    <x-slot:heading>
        Home Page
    </x-slot:heading>
    
@foreach($jobs as $job)
    <li><strong>{{ $job['title'] }}</strong> pays {{ $job['salary'] }} per year</li>
@endforeach

    <!-- <h1>Hello from the home page</h1> -->
</x-layout>