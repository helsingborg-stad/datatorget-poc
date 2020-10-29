using System;
using System.Xml.Linq;

namespace bokningsapi.code
{
    internal class Dagsschema
    {
        public DayOfWeek Veckodag { get; set; }
        public int StartTid { get; set; }
        public int SlutTid { get; set; }

        public Dagsschema()
        {
        }

        public Dagsschema(XElement src)
        {
            Veckodag = GetDayOfWeek(src.Attribute("id").Value);
            StartTid = int.Parse(src.Attribute("startTime").Value);
            SlutTid = int.Parse(src.Attribute("endTime").Value);
        }

        private DayOfWeek GetDayOfWeek(string str)
        {
            if (Enum.TryParse<DayOfWeek>(str, true, out var result))
                return result;
            throw new Exception($"Invalid DayOfWeek {str}"); 
        }
    }
}
