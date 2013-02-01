
class ficha4
{
	ArrayList _polignos;

	public static void main(String[] args)
	{
		boolean more = false;
		
		_polignos = new ArrayList();
		
		do
		{
			Poligno poli = new Poligno();
			
			System.out.print("lados (por ordem)? = ");
			int sides = User.ReadInt();
			
			for (int i = 0; i < sides; i++)
			{
				System.out.println("x =");
				int x = User.ReadInt();
				
				System.out.println("y =");
				int y = User.ReadInt();
				
				poli.addSide(x,y);
			}
		
			System.out.print("mais um?:");
			if ("s".equals(User.ReadString()))
			{
				more = true;
			}
			
			
			// append to poligno list
			_polignos.add(poli);

			
		}
		while (more);
		
		
		for (int i = 0; i < _polignos.size(); i++)
		{
			System.out.print("Poligno %s (nº%d) ", _poligonos.get(i), i);
			
			if(!_polignos.get(i).isRegular())
				System.out.print("nao ");
	
			System.out.println("e' regular.");
		}

	}
}