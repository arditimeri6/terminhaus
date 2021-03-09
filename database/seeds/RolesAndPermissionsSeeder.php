<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'create administrator']);
        Permission::create(['name' => 'edit administrator']);
        Permission::create(['name' => 'delete administrator']);

        Permission::create(['name' => 'create call_center_admin']);
        Permission::create(['name' => 'edit call_center_admin']);
        Permission::create(['name' => 'delete call_center_admin']);

        Permission::create(['name' => 'create berater_admin']);
        Permission::create(['name' => 'edit berater_admin']);
        Permission::create(['name' => 'delete berater_admin']);

        Permission::create(['name' => 'create call_center_direktor']);
        Permission::create(['name' => 'edit call_center_direktor']);
        Permission::create(['name' => 'delete call_center_direktor']);

        Permission::create(['name' => 'create broker_direktor']);
        Permission::create(['name' => 'edit broker_direktor']);
        Permission::create(['name' => 'delete broker_direktor']);

        Permission::create(['name' => 'create agent_team_leader']);
        Permission::create(['name' => 'edit agent_team_leader']);
        Permission::create(['name' => 'delete agent_team_leader']);

        Permission::create(['name' => 'create quality_controll']);
        Permission::create(['name' => 'edit quality_controll']);
        Permission::create(['name' => 'delete quality_controll']);

        Permission::create(['name' => 'create berater_team_leader']);
        Permission::create(['name' => 'edit berater_team_leader']);
        Permission::create(['name' => 'delete berater_team_leader']);

        // Permission::create(['name' => 'create leads_agent']);
        // Permission::create(['name' => 'edit leads_agent']);
        // Permission::create(['name' => 'delete leads_agent']);

        Permission::create(['name' => 'create agents']);
        Permission::create(['name' => 'edit agents']);
        Permission::create(['name' => 'delete agents']);

        Permission::create(['name' => 'create berater']);
        Permission::create(['name' => 'edit berater']);
        Permission::create(['name' => 'delete berater']);

        // Permission::create(['name' => 'create virtual_user']);
        // Permission::create(['name' => 'edit virtual_user']);
        // Permission::create(['name' => 'delete virtual_user']);

        $roleAdministrator = Role::create(['name' => 'Administrator']);
        $roleAdministrator->givePermissionTo(Permission::all());

       
       

        $roleCallCenterDirektor = Role::create(['name' => 'Call Center Direktor']);
        $roleCallCenterDirektor->givePermissionTo([
            'create agent_team_leader', 'edit agent_team_leader', 'delete agent_team_leader',
            'create quality_controll', 'edit quality_controll', 'delete quality_controll',
            'create agents', 'edit agents', 'delete agents','edit call_center_direktor'
        ]);

        $roleBrokerDirektor = Role::create(['name' => 'Broker Direktor']);
        $roleBrokerDirektor->givePermissionTo([
            'create berater_team_leader', 'edit berater_team_leader', 'delete berater_team_leader',
            'create berater', 'edit berater', 'delete berater','edit broker_direktor'
        ]);

        $roleAgentTeamLeader = Role::create(['name' => 'Agent Team Leader']);
        $roleAgentTeamLeader->givePermissionTo([
            'create agents', 'edit agents', 'delete agents', 'edit agent_team_leader',
        ]);

        $roleQualityControll = Role::create(['name' => 'Quality Controll']);
        $roleQualityControll->givePermissionTo([
            'edit quality_controll',
        ]);

        $roleBeraterTeamLeader = Role::create(['name' => 'Berater Team Leader']);
        $roleBeraterTeamLeader->givePermissionTo([
            'create berater', 'edit berater', 'delete berater','edit berater_team_leader',
        ]);

        
        $roleAgents = Role::create(['name' => 'Agent']);

        $roleBerater = Role::create(['name' => 'Berater']);

        $roleCallCenterAdmin = Role::create(['name' => 'Call Center Admin']);
        $roleCallCenterAdmin->givePermissionTo([
            'create call_center_direktor','edit call_center_direktor', 'delete call_center_direktor',
            'create agent_team_leader', 'edit agent_team_leader', 'delete agent_team_leader',
            'create quality_controll', 'edit quality_controll', 'delete quality_controll',
            'create agents', 'edit agents', 'delete agents', 'edit call_center_admin'
        ]);

        $roleBeraterAdmin = Role::create(['name' => 'Berater Admin']);
        $roleBeraterAdmin->givePermissionTo([
            'create broker_direktor','edit broker_direktor','delete broker_direktor',
            'create berater_team_leader', 'edit berater_team_leader', 'delete berater_team_leader',
            'create berater', 'edit berater', 'delete berater', 'edit berater_admin',
        ]);


        // $roleLeadsAgent = Role::create(['name' => 'Leads Agent']);


        // $roleVirtualUser = Role::create(['name' => 'Virtual User']);
    }
}
