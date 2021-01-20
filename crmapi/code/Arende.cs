using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace crmapi.code
{
    public class Arende
    {
        public int ArendeId { get; set; }
        public string Beskrivning { get; set; }
        public int Kundnr { get; set; }
        public string Namn { get; set; }
        public string Epost { get; set; }
        public bool Completed { get; set; }
    }
}
