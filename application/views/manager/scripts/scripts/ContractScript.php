<script type="text/javascript">
	$(function(){

		$(".delete").click(function(){
			var contractId=$(this).attr('contractId');	
			var contractName=$(this).attr('contractName');
			if(confirm("Are you sure you want to delete Conatrct- '"+contractName+"' ?"))
			{
		        $(".delete").attr("href", "<?php echo base_url(); ?>Manager/deleteContract/"+btoa(contractId));
		    }
		    else{
		        return false;
		    }
		});
	});
</script>