Exame de recurso 2008

pergunta 2 - Colocaria na classe Hotel

public void WriteToFile(int limite){
	try{
		File f = new File("Reservas_anuladas.txt");
		FileWriter fs = new FileWriter(f);
		PrintWriter ps = new PrintWriter(fs);
		String Anuladas = " ";
		
		for (i=0; i<ListaClientes.size(); i++){
			for(j=0; j<ListaReservas.size(); j++){
				if (ListaClientes.get(i).ListaReservas.get(j).reservaAnulada() == 1){
					if (ListaReservas.get(j).getNumDias() >= limite){
						Anuladas += "id: "+ListaClientes.get(i).get_id()+" nome: "+ListaClientes.get(j).get_nome()+" nº de dias anulados: "+ListaReservas.get(j).getNumDias() + "\n";
					}
				}
			}
		 }
		ps.println(Anuladas);
		}
	ps.close();
	}
	catch (IOException e){
		System.out.println("Ocorreu uma excepção "+e+" ao criar o FileWriter fs");
	}
}

pergunta 3 - 
IGNORAR ESTA FUNÇAO!
public int NumDiasAPagar(){

	Data data_hoje = new Data();
	data_hoje = data_hoje.getDataHoje();
	
	for (i=0; i<ListaClientes.size(); i++){
		for(j=0; j<ListaReservas.size(); j++){
			if (data_hoje.getYear() - ListaReservas.get(j).get_DataDaReserva().getYear() >= 1){*****************************************************************
				ListaReservas.remove(j);
				ListaClientes.get(i).add_reserva();
					
CONSIDERAR ESTA FUNÇAO
//metodo em Clientes que consoante o numero de dias de reserva retorna o numero int de dias a pagar.
public String add_reserva(int n_dias){
	//Reserva res = new Reserva();
	for(k=0; k<ListaClientes.size(); k++){
		int c = n_dias/ListaClientes.get(i).get_n_dias();
		return "tem a pagar: "+n_dias-c;
	}
}	
					
					
					