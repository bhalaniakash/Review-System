<style>
    
    table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 0.75rem;
    border: 1px solid #dee2e6;
}
thead {
    background-color: #f8f9fa;
}
th {
    font-weight: bold;
    text-align: left;
}
td {
    text-align: left;
}
body {
    font-family: 'Nunito', sans-serif;
    background-color: #f9fafb;
    color: #374151;
}
   
</style>

   
        <x-app-layout>
            
                <x-slot name="header">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Dashboard') }}
                    </h2>
                </x-slot>
                
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-semibold mb-4">Guest Feedback</h3>
                            
                            
                            @if($feedbacks->isEmpty())
                            <p>No feedback submitted yet.</p>
                            @else
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th>Email</th>
                                        <th>Submitted At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($feedbacks as $feedback)
                                    <tr>
                                        <td>{{ $feedback->name }}</td>
                                        <td>{{ $feedback->rating }}</td>
                                        <td>{{ $feedback->comment }}</td>
                                        <td>{{ $feedback->email ?? 'N/A' }}</td>
                                        <td>{{ $feedback->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                      
                        @endif
                    </div>
                </div>
            </div>
        
</x-app-layout>
