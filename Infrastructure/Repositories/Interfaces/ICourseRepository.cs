using LMSService.Domain.DTOs.Course;
using LMSService.Domain.Entities.Concretes;

namespace LMSService.Infrastructure.Repositories.Interfaces
{
    public interface ICourseRepository : IRepository<Course, int>
    {
        Task<Course?> Create(CreateCourseDTO entity);
        Task<IEnumerable<Course>> GetUserCoursesById(int userId, int pageNumber, int pageSize);
    }
}
