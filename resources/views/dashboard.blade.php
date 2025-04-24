<!DOCTYPE html>
<html lang="en">
<head>
  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        
        .app{
        font-family: 'Inter', sans-serif;
        background-color: #F8F4E1;
        color: #4E1F00;
        margin: 0;
        padding: 0;
    }

        table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        color: #4E1F00;
        background-color: #FEBA17;
    }
    th, td {
        color: #4E1F00;
        background-color: #FEBA17;
        padding: 0.75rem;
        border: 1px solid #dee2e6;
    }
  
    th {
        font-weight: bold;
        text-align: left;
    }
    td {
        text-align: left;
    }
    
    body {
        font-family: 'Inter', sans-serif;
        background-color: #F8F4E1;
        color: #4E1F00;
        margin: 0;
        padding: 0;
    }
        
    .btn-primary , .btn-outline-danger {
        background-color:  #FEBA17;
        border-color: #4E1F00;
        color: #4E1F00;
    }
    .btn-primary:hover,
    .btn-outline-danger:hover {
        background-color: #4E1F00;
        border-color: #4E1F00;
        color: #FEBA17;
    }

    .py-12{
        background-color:#F8F4E1;
        color: #4E1F00;
    }
    .container{
        background-color: #74512D;
        color: #FEBA17;
        padding: 20px;
    }

    footer{
        background-color: #FEBA17;
        color: #4E1F00;
        padding: 1rem;
        text-align: center;
        /* position: fixed; */
        bottom: 0;
        width: 100%;
        box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
    }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    
    
    <x-app-layout class="app">
        
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">  
                {{ __('Dashboard') }}
            </h2>
        </x-slot>
        
        <div class="py-12">
            <div class="container max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                    <h3 class="text-lg font-semibold mb-4">Guest Feedback</h3>
                    
                    <div>
                        <form onsubmit="filterTable(event)">
                            <input type="text" id="searchInput" placeholder="Search by Name, Email, or Comment">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <button type="button" class="btn btn-outline-danger" onclick="filterCompleted()">Completed</button>
                        </form>
                    </div>
                            
                        @if($feedbacks->isEmpty())
                        <p>No feedback submitted yet.</p>
                        @else
                        <table class="table table-bordered" id="myTable" >
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Email</th>
                                    <th>Submitted At</th>
                                    <th>address</th>
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
                                    <td> 
                                        <input type="checkbox" name="addressed" value="1" {{ $feedback->addressed ? 'checked' : '' }} 
                                        data-id="{{ $feedback->id }}" class="addressed-checkbox" onchange="updateAddressedStatus(this)">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                        <br>
                        <button onclick="downloadTableAsCSV()" class="btn btn-success">Download CSV</button>
                        @endif
                        
                    </div>
            </div>
            <footer>
                <P>all rights recieved by @akashbhalnai21@gmail.com</P>
                </footer>

<script>
                
                // update csv 
                
                function updateAddressedStatus(checkbox) {
                    const feedbackId = checkbox.getAttribute('data-id');
        const addressed = checkbox.checked ? 1 : 0;

        fetch(`/feedbacks/${feedbackId}/update-addressed`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ addressed: addressed })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to update addressed status');
            }
            return response.json();
        })
        .then(data => {
            console.log('Addressed status updated successfully:', data);
        })
        .catch(error => {
            console.error('Error updating addressed status:', error);
            alert('Failed to update addressed status. Please try again.');
            checkbox.checked = !addressed; // Revert checkbox state on failure
        });
    }
    
    // download csv 
    
    function downloadTableAsCSV(filename = 'data.csv') {
        const table = document.getElementById("myTable");
        let csv = [];
        
        for (let row of table.rows) {
            let rowData = [];
            for (let cell of row.cells) {
                rowData.push(cell.textContent.trim());
            }
            csv.push(rowData.join(","));
        }
        
        const csvData = new Blob([csv.join("\n")], { type: 'text/csv' });
        const link = document.createElement("a");
        
        link.href = URL.createObjectURL(csvData);
        link.download = filename;
        link.click();
    }
    
    
    // for the filter
    
    function filterTable(event) {
        event.preventDefault();
        const input = document.getElementById('searchInput').value.toLowerCase();
        const table = document.getElementById('myTable');
        const rows = table.getElementsByTagName('tr');
        
        for (let i = 1; i < rows.length; i++) { 
            const cells = rows[i].getElementsByTagName('td');
            let match = false;
            
            for (let cell of cells) {
                if (cell.textContent.toLowerCase().includes(input)) {
                    match = true;
                    break;
                }
            }
            
            rows[i].style.display = match ? '' : 'none';
        }
    }
    
    let filterApplied = false;
    
    function filterCompleted() {    
        const table = document.getElementById('myTable');
        const rows = table.getElementsByTagName('tr');
        
        if (filterApplied) {
            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = '';
            }
            filterApplied = false;
        } else {
            for (let i = 1; i < rows.length; i++) {
                const checkbox = rows[i].querySelector('.addressed-checkbox');
                if (checkbox) {
                    rows[i].style.display = checkbox.checked ? '' : 'none';
                }
            }
            filterApplied = true;
        }
    }
    
</script>

</body>
</html>
</x-app-layout>