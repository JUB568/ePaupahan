<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History - ePaupahan</title>
    <link rel="stylesheet" href="new.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <div class="sidebar-header">
                <img src="white.png" alt="Sidebar Logo" class="sidebar-image">
                <h2>ePaupahan</h2>
                <h5>Tenant Portal</h5>
            </div>
            <ul class="sidebar-nav">
                <li><a href="tenant-dashboard.php" ><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="tenant-payments.php" ><i class="fas fa-credit-card"></i> Payment History</a></li>
                <li><a href="tenant-requestmaintainance.php" ><i class="fas fa-tools"></i> Request Maintenance</a></li>
                <li><a href="tenant-rulespolicies.php" class="active"><i class="fas fa-gavel"></i> Rules and Policies</a></li>
                <li><a href="tenant-profile.php" ><i class="fas fa-user"></i> Profile</a></li>
                
            </ul>
            <li class="logout-li"><a href="login.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </nav>

        <main class="main-content">
            <header class="top-bar">
                <h1>Please take time to read.</h1>
            </header>

        <div class="rules-container">
        <h1>Apartment Rules and Regulations</h1>

            <div class="rule">
                <h2>1. Rental and Fees</h2>
                <p> -Payments are made every month, based on the day of move-in.</p>
                <p> -We require a 1-month advance and 1-month deposit upon moving in.</p>
                <p> -The 1-month deposit is refundable but not consumable. It will serve as payment for:
                    (Any unpaid dues on bills from previous months.)
                    (Penalties for any damages to the property, if applicable.)</p>
                <p> -The total amount due will be deducted from your deposit before moving out.</p> 
                <p> -Failure to pay within three (3) months may result in termination of the right to reside in the apartment or unit.</p> 
                
            </div>

            <div class="rule">
                <h2>2. Bills and Payment for:</h2>
                <p> -Every Unit has its own meter/submeter for electricity that will be computed depending on the KWH that it consumes upon moving in up to monthly due.</p>
                <p> -We require a monthly payment of P500 for water bills on every unit, it includes other minimum water charges and electricity consumption for a water pump.</p>
                <p> -The units on the first floor had their own water and electricity meter that they needed to pay every month.</p>
            </div>

            <div class="rule">
                <h2>3. Door Locks, Windows, and Keys</h2>
                <p> -Ensure all doors and windows are closed and locked when nobody is at home.</p>
                <p> -Use the double lock inside the room when all your roommates are present.</p>
                <p> -Always bring your key with you and avoid losing it.</p>
                <p> -Avoid opening windows, especially at night, to protect your safety and belongings.</p>
            </div>

            <div class="rule">
                <h2>4. Vacating</h2>
                <p> -Boarders/renters are required to notify management at least 1 month before vacating the room.</p>
                <p> -Failure to provide proper notice will result in the lease being considered ongoing, and you will still be responsible for rent until notice is given.</p>
            </div>

            <div class="rule">
                <h2>5. Maintainance</h2>
                <p> -Maintenance work may be conducted at any time within the affected premises.</p>
                <p> -Affected renters must cooperate when needed.</p>
            </div>

            <div class="rule">
                <h2>6. Issues and Concerns</h2>
                <p> -Please do not hesitate to contact or inform management regarding any issues or concerns related to the apartment.</p>
            </div>

            <div class="rule">
                <h2>7. Kitchen</h2>
                <p> -Leftover food must be placed in the designated area outside the apartment. Do not throw it into the trash can to avoid odors and pest infestations.</p>
                <p> -Do not use a FURNACE or PUGON inside the unit.</p>
            </div>

            <div class="rule">
                <h2>8. Toilet and Bathroom</h2>
                <p> -Clean up after use by removing fallen hair from drains and floors and disposing of shampoo, soap, and conditioner sachets in the trash.</p>
                <p> -Do not flush tissues, wipes, pads, sanitary items, or any other non-biodegradable materials down the toilet.</p>
                <p> -Ensure faucets are properly closed to prevent water leakage.</p>
                <p> -Notify management immediately if you notice a leak.</p>
                <p> -Always flush the toilet properly and turn off the lights when not in use.</p>
                <p> -Strictly No Smoking inside the Bathroom.</p>
            </div>

            <div class="rule">
                <h2>9. Garbage Disposal</h2>
                <p> -Collect your own garbage. We will collect all of the garbage once/twice a week and charge Ten pesos (P10.00) per unit for the payment for throwing at the dumpsite.</p>
            </div>

            <div class="rule">
                <h2>10. Rooms</h2>
                <p> -Practice common courtesy and respect others' personal space.</p>
                <p> -Always be kind and considerate to your roommates.</p>
                <p> -Do not make any changes to the room (e.g., adding wallpaper, painting, or customizing your bed/unit).</p>
                <p> -Be responsible for your personal belongings. The management will not be held accountable for lost or missing items.</p>
                <p> -Strictly No Smoking in rooms and hallways.</p>
            </div>

            <div class="rule">
                <h2>11. Internet/WIFI</h2>
                <p> -Free/shared Wi-Fi is provided.</p>
                <p> -Internet speed is not guaranteed at 100%. If you experience slow connections that affect your work or study, you may install your own modem/wifi.</p>
            </div>
        
        <h1>House Rules and Regulations</h1>
             <div class="regulations">
                <h2>1. Rules</h2>
                <p> -No pets allowed.</p>
                <p> -No smoking inside the room and building.</p>
                <p> -Visitors are allowed until 7:00 PM. No overnight visitors (except for parents/guardians).</p>
                <p> -Curfew is at 11:30 PM.</p>
                <p> -Observe quiet time starting at 10:00 PM. Please keep noise to a minimum during this time.</p>
            </div>

            <div class="regulations">
                <h2>2. Cleanliness</h2>
                <p> -Always observe cleanliness.</p>
                <p> -Maintain a clean environment both inside and outside your room.</p>
                <p> -Practice CLAYGO (Clean As You Go), especially in the comfort room and kitchen sink.</p>
                <p> -Dispose of garbage properly in the designated bins and segregate your trash into biodegradable and non-biodegradable.</p>
                <p> -Do not throw leftover food into the sink, as it may cause pipe blockages.</p>
            </div>

            <div class="regulations">
                <h2>3. Water And Electricity</h2>
                <p> -Ensure faucets are turned off after use.</p>
                <p> -Switch off lights when not in use.</p>
                <p> -Unplug appliances and chargers when not in use, especially when leaving.</p>
                <p> -Avoid OVERNIGHT CHARGING to prevent overheating and reduce fire risk.</p>
            </div>

            <div class="regulations">
                <h2>4. Visitor Policy</h2>
                <p> -Only direct family members are allowed to visit or check the room; inform management if there will be an emergency case for an exception.</p>
                <p> -No members of the opposite gender are allowed inside the room.</p>
            </div>

            <div class="regulations">
                <h2>5. Violation</h2>
                <p> -We prioritize your well-being, safety, and the condition of the apartment. Any violations will result in a warning after (3) three warnings and management reserves the right to evict you from the premises.</p>
                <p> -Note (Management reserves the right to enter and inspect the room anytime, if legally permissible or when the tenants are present.)</p>
            </div>
            
        </div>
    </div>

</body>
</html>