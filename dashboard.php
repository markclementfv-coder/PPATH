<?php
// 1. Establish Database Connection & Session Tracking
$conn = new mysqli('localhost', 'root', '', 'ppath');
session_start();

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Guard Clause: If unauthenticated, redirect to login page
if (!isset($_SESSION['userId'])) {
    header("Location: index1.php");
    exit();
}

// 2. Fetch all records from the 'attendees' table
$sql = "SELECT * FROM attendees ORDER BY name ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPATH Dashboard | Attendees List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-800 flex flex-col min-h-screen">

    <nav class="bg-white shadow px-6 py-4 flex justify-between items-center border-b border-gray-200">
        <div class="flex items-center space-x-2">
            <span class="text-xl font-bold text-indigo-600 tracking-tight">PPATH</span>
            <span class="text-gray-300">|</span>
            <span class="text-sm text-gray-500 font-medium">Monitoring System</span>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="text-right">
                <span class="block text-xs text-gray-400 font-semibold uppercase tracking-wider">Logged In As</span>
                <span class="text-sm font-bold text-gray-900">
                    Admin: <?php echo htmlspecialchars($_SESSION['userName']); ?>
                </span>
            </div>
            
            <button onclick="confirmLogout()" class="text-sm bg-red-50 border border-red-200 px-3 py-2 rounded-lg text-red-600 font-semibold hover:bg-red-100 transition shadow-sm">
                Log Out
            </button>
        </div>
    </nav>

    <main class="max-w-6xl w-full mx-auto p-4 sm:p-6 lg:p-8 flex-grow">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            <div class="p-6 border-b border-gray-200 bg-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Registered Attendees Matrix</h2>
                    <p class="text-xs text-gray-500 mt-1">Review monitored profiling info or export files directly to your machine.</p>
                </div>
                
                <div class="flex gap-2 w-full sm:w-auto">
                    <button onclick="exportToCSV()" class="flex-1 sm:flex-initial text-center bg-white border border-gray-300 text-gray-700 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-gray-50 transition shadow-sm">
                        Export CSV
                    </button>
                    <button onclick="exportToExcel()" class="flex-1 sm:flex-initial text-center bg-emerald-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-emerald-700 transition shadow-sm">
                        Export Excel (.xlsx)
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table id="attendance-table" class="w-full text-left text-sm border-collapse">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="p-4 font-semibold text-gray-700 w-16">#</th>
                            <th class="p-4 font-semibold text-gray-700">Full Name</th>
                            <th class="p-4 font-semibold text-gray-700">Gender</th>
                            <th class="p-4 font-semibold text-gray-700">Age</th>
                            <th class="p-4 font-semibold text-gray-700">Category</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php
                        $count = 1; // Increment tracker for visual styling
                        
                        // 3. Loop through database records and output table rows dynamically
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                
                                // Color-code your specific operational categories dynamically
                                $categoryBadgeClass = "bg-gray-100 text-gray-800";
                                $cleanCategory = strtolower(trim($row['category']));

                                if (strpos($cleanCategory, 'probation') !== false) {
                                    $categoryBadgeClass = "bg-blue-100 text-blue-800";
                                } elseif (strpos($cleanCategory, 'parole') !== false) {
                                    $categoryBadgeClass = "bg-purple-100 text-purple-800";
                                } elseif (strpos($cleanCategory, 'admin') !== false || strpos($cleanCategory, 'officer') !== false) {
                                    $categoryBadgeClass = "bg-emerald-100 text-emerald-800";
                                }
                                ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 font-mono text-gray-400"><?php echo $count++; ?></td>
                                    <td class="p-4 font-semibold text-gray-900"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td class="p-4 text-gray-600 capitalize"><?php echo htmlspecialchars($row['gender']); ?></td>
                                    <td class="p-4 text-gray-600 font-mono"><?php echo htmlspecialchars($row['age']); ?></td>
                                    <td class="p-4">
                                        <span class="<?php echo $categoryBadgeClass; ?> text-xs px-2.5 py-1 rounded-full font-bold uppercase tracking-wider">
                                            <?php echo htmlspecialchars($row['category']); ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            // Display a placeholder message if the attendees table is completely empty
                            echo "<tr><td colspan='5' class='p-8 text-center text-gray-400 font-medium'>No metrics found matching columns inside database table 'attendees'.</td></tr>";
                        }
                        // Close connection structures cleanly
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

    <script>
        function confirmLogout() {
            if (confirm("Are you sure you want to log out of the PPATH system?")) {
                window.location.href = "logout.php";
            }
        }

        function exportToExcel() {
            const table = document.getElementById('attendance-table');
            const workbook = XLSX.utils.table_to_book(table, { sheet: "PPATH Records" });
            XLSX.writeFile(workbook, "PPATH_Attendees_Report.xlsx");
        }

        function exportToCSV() {
            const rows = Array.from(document.querySelectorAll('#attendance-table tr'));
            const csvContent = "data:text/csv;charset=utf-8," 
                + rows.map(r => Array.from(r.querySelectorAll('th, td')).map(c => `"${c.innerText.trim()}"`).join(",")).join("\n");
            
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "PPATH_Attendees_Report.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>
</html>