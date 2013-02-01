EXAME NORMAL 2008

pergunta 2 -

//EM LOJA
public String actualiza(String marca, String modelo, int num_serie){
	for(i=0; i<ListaDispositivos.size(); i++){
		if((ListaDispositivos.get(i).get_marca().equals(marca))&&(ListaDispositivos.get(i).get_modelo().equals(modelo))){
			ListaDispositivos.get(i).vende();
			for(j=0;j<Lista_Stock.size();j++){
				if((ListaDispositivos.get(i).Lista_Stock.size()) < ((ListaDispositivos.get(i).get_Stock_min()){
					return "Dispositivo: "+ListaDispositivos.get(i) + " em falta!";
				}
			}
		}
	}
}
//metodo  em DISPOSITIVOS
public void vende(int num_serie){		
	for(j=0;j<Lista_Stock.size();j++){
		if((Lista_Stock.get(j)==num_serie)){
			Lista_Stock.remove(num_serie);
		}
	}
}

//metodo em DISPOSITIVOS que diga quantos ainda há
public int quantosha(){
	return Lista_Stock.size();
}

pergunta 3 - COLOCARIA CLASSE LOJA!


//em LOJA
public double promocao(){
	double total = 0;
	for (i=0;i<ListaDispositivos.size();i++){
		total += ListaDispositivos.get(i).get_preçovenda();
		
//em portatil o metodo abstract seria:
public double preço_venda(){
	if (super.Lista_Stock.size() >= super.get_Stock_min()){
		desconto = 0.05+0.1*(super.Lista_Stock.size() - super.get_Stock_min());
	else{				
		desconto = 0.05;
		subtotal2 += (1-desconto) * (super.Lista_Stock.size());
	//return (0.95-( (int n = super.Lista_Stock.size() - super.get_Stock_min()) > 0? 0.01*n : 0)) * super.Lista_Stock.size();
		
		
public double vendas_promocao(){
	double subtotal1 = 0;
	double subtotal2 = 0;
	double total;
	double desconto;
	for(i=0;i<ListaDispositivos.size();i++){
		if(ListaDispositivos.get(i) instanceof Telemovel){
			promo_tele = (ListaDispositivos.get(i).get_preco_venda() * 0.95);
			subtotal1 += promo_tele * (ListaDispositivos.get(i).Lista_Stock.size());
		else if(ListaDispositivos.get(i) instanceof Portatil){
			if (ListaDispositivos.get(i).Lista_Stock.size() >= ListaDispositivos.get(i).get_Stock_min()){
				desconto = 0.05+0.1*(ListaDispositivos.get(i).Lista_Stock.size() - ListaDispositivos.get(i).get_Stock_min());
			else{
				desconto = 0.05
			subtotal2 += (1-desconto) * (ListaDispositivos.get(i).Lista_Stock.size());
			}
			}
		}
		}
	}
	return total = subtotal1 + subtotal2;
}
	

	
	
	
