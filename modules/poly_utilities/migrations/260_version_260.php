<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_253 extends App_module_migration
{
    public function up()
    {
        // Perform database upgrade here
    }
    public function down()
    {
        // Perform database downgrade here
    }
    public function logChanged()
    {
        /*
        -------- 2.6.0 (November 30, 2024) --------
        P/S: In case you encounter any conflicts during usage, please leave feedback or contact me at polyxgo@gmail.com. I will support you right away! Thanks.
       
        FIXED
        - Fixed lỗi mất icon edit project.

        NEW
        - Add languages and translations: 
        
        TASKS in PROGRESS
        - Custom Data Table: tùy chỉnh sắp xếp thứ tự hiển thị các cột dữ liệu. Drag & Drop để di chuyển sắp xếp lại thứ tự các cột trên các bảng dữ liệu.
        - Widget allows displaying language menu and flag icons in widget areas: admin, staff, clients, and within article details.
        - Reset menu items with missing SVG icons.
        - Fixed the non-functional delete confirmation for Todo items.
        - Supports managing, categorizing, and creating a list of task templates for new project creation. You no longer need to create generic tasks for most projects, such as gathering client requirements, feature lists, design, feature integration, handover, etc.
        - Right-click menu with multi-level access to system components. Supports role-based permissions. Each staff account or role will see a menu tailored to the tools they use.
        */
    }
}
