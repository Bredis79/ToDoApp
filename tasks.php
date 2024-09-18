
<div class="container">
<input type="checkbox" name="" id="hamburger-menu">
        <header class="header">


            <div class="add-task-wrap">
                <form method="post">
                    <label for="ukol">New task</label>
                    <input type="text" name="ukol" id="ukol" placeholder="Add some task here">
                    <?php if ($error) : ?>
                        <div class="error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <button name="vlozit" class="btn">Add task</button>
                </form>            
            </div>

            <div class="user-area-obal">
                
                <div class="user-area">
                    <form method="post" class="user-area__form">
                        <div class="alias"><?php echo $_SESSION["prihlasenyUzivatel"];?></div>
                        <i class="fa-solid fa-user"></i>
                        <button name="odhlasit" class="odhlasitBtn">Log out</button>
                    </form>
                </div>
                
                 
                
            </div>

            <div class="hamburger-menu">
                <label for="hamburger-menu">
                    <div class="linka jedna"></div>
                    <div class="linka dva"></div>
                    <div class="linka tri"></div>
                </label>
            </div>
        </header>
   

    <div class="seznam-ukolu">
        <div class="vypis-ukolu">
            <ol class="column">
               
  <header><h1>Your tasks</h1></header>

            <?php
                 
                // vypis úkolů
                foreach($ukoly as $ukol) {
                    
                    // pokud se klikne na iconu editace, tak ze zobrazí editační část
                    if ($editace == true && $editaceId == $ukol['id']) {
                        echo "<br>";
                        echo "<li>
                            <form>
                                <input type='text' name='ukol' value='" . htmlspecialchars($ukol['ukol']) . "' />
                                <button name='save' value='" . htmlspecialchars($ukol['id']) . "'>
                                    <i class='fa-solid fa-floppy-disk'></i>
                                </button>
                            </form>
                        </li>";
                    
                    } else {
                        // zobrazí se normální výpis
                        echo "<br>";
                        echo "<li>{$ukol["ukol"]}
                        <div class='task-tools'>
                            <a href='?edit={$ukol['id']}'><i class='fa-solid fa-pen'></i></a>
                            <a href='?delete={$ukol['id']}'><i class='fa-solid fa-trash-can'></i></a>
                        </div>
                        </li>";
                    }
                }
                           
            ?>
            </ol>

        </div>
    </div>
</div>