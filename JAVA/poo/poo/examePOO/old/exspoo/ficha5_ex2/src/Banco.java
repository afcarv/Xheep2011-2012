
public class Banco {

	public static void main(String[] args) {
		
		Cliente bots[] = new Cliente[20];
		
		int n_clientes = 5;
		
		bots[0] = new Cliente("Manuel", 10328748, "prazo", 9874.5);
		bots[1] = new Cliente("Jorge", 12345678, "ordem", 454.78);
		bots[2] = new Cliente("Anabela", 98748736, "prazo", 9834.45);
		bots[3] = new Cliente("Beatriz", 89427050, "prazo", 876.2342);
		bots[4] = new Cliente("Mario", 16309573, "ordem", 223467.89);

		
		
		String deseja;
		while(true) {
			
		System.out.println("\no que deseja fazer?\n\n NovoCliente(1)\n Levantamento(2)\n Deposito(3)\n Consulta(4)\n Cliente com mais de x € (5)\n qts_dias_faltam_p_vencer_juro(6)\nSair(0)");
		deseja = User.readString();
		

			
		if (deseja.equals(0)){
			break;
		}
			
		else if (deseja.equals("1")){
				
				System.out.println("introduziu a opçao adicionar cliente!");
				System.out.print("introduza o nome do Cliente: ");
				String name = User.readString();
				
				System.out.print("introduza o numero de conta do cliente: ");
				int numero = User.readInt();
				
				System.out.print("introduza o tipo de conta do futuro cliente: ");
				String tipo_conta = User.readString();
				
				System.out.print("introduza o saldo do cliente: ");
				double saldo_cliente = User.readDouble();
				
				bots[n_clientes] = new Cliente(name, numero, tipo_conta, saldo_cliente);
				n_clientes++;
			}

		
		else if (deseja.equals("2")){
			
			System.out.print("Qual o seu numero de conta? ");
			int conta = User.readInt();
			
			System.out.print("Introduza o montante a levantar: ");
			double valor = User.readDouble();
			
			for (int k=0; k<n_clientes; k++){
				if ((bots[k].getNum_conta() == conta) && (bots[k].get_saldo() > 0)){
					bots[k].levantamento(valor);
					break;
				}
				}
			}
		else if (deseja.equals("3")){
			System.out.print("Qual o seu numero de conta? ");
			int conta = User.readInt();
			System.out.print("Introduza o montante a depositar: ");
			double valor = User.readDouble();
			
			for (int k=0; k<n_clientes; k++){
				if ((bots[k].getNum_conta() == conta)){
					bots[k].deposito(valor);
					break;
				}
			}
			
		}
		else if (deseja.equals("4")){
			System.out.println("introduza o seu numero de conta: ");
			int conta = User.readInt();
			
			for (int k=0; k<n_clientes; k++){
				if ((bots[k].getNum_conta() == conta)){
					bots[k].Consulta_de_saldo();
				}
			}
		}
		
		else {
			System.out.println("Comando inválido.");
			continue;//passa pro inciio do ciclo
			
		}
		}
	}
}