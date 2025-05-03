using LMSService.Infrastructure.Connectors.Abstracts;
using LMSService.Infrastructure.Connectors.Interfaces;

namespace LMSService.Infrastructure.Repositories.Concretes
{
    public class CourseRepository : AbstractCourseRepository
    {
        public CourseRepository(ILMSConnector lmsConnector) : base(lmsConnector)
        {
        }
    }
}
