 if(isset($_FILES['import'], $_POST['submit']) && !empty($_FILES['import']['name'])){
                       if(@include_once 'excel/PHPExcel.php'){
                           var_dump($_FILES['import']['tmp_name']);
                           $tmpfname = $_FILES['import']['tmp_name'];
                           $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
                           $excelObj = $excelReader->load($tmpfname);
                           $worksheet = $excelObj->getActiveSheet();
                           $lastcol = $worksheet->getHighestColumn();
                           $lastcol++;
                           $ge = mysql_query('select parameters from list'); // where parameter list is a comma separated list for column values
                           if(mysql_num_rows($ge) == 1){
                           $get = mysql_fetch_array($ge);
                               $adt = explode(';}:;{;', $get['parameters']);
                               $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'J', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'V', 'W', 'X', 'Y', 'Z'];
                               
                               ?>
                        <center>
                           
                        <div class="row" style="width: 100%">
                            <div align="left">   
                            <?php
                           for($col = 'A'; $col != $lastcol; $col++){ ?>
                                <div class="col-lg-3 match">
                                    <div class="match-head">
                                        Select column name<br>
                                        <?php if(!in_array($worksheet->getCell($letters[$col].'1')->getValue(), $adt)){
                                            echo "<span style=\"color: red\">Unmatched column</span><br>";
                                            $vr = "";
                                        }else{
                                            $vr = " selected";
                                        } ?>
                                        <select name="qx[]">
                                            <option value="">Choose column name</option>
                                            <?php 
                                            foreach($adt as $vg){?>
                                            <option value="<?php echo $vg;?>"><?php echo $vg; ?></option>
                                            <?php }
                                            ?>
                                        </select><br>
                                        <?php var_dump($worksheet->getCell('A'.$row)->getValue());?> 
                                    </div>
                                </div>
                           <?php } ?>
                            </div>
                        </div></center>
                               <?php
                       }else{
                        ?>
                        <center><h3>Sorry! List was not found!</h3><br>
                            
                   <?php   
                       }
                       
                           }else{ ?>
                        <center><h3>Sorry! An unexpected error occurred! Please try again later</h3><br>
                            
                   <?php }
                   }